$ = $j = jQuery.noConflict();


$('iframe[src^="javascript"]').prev('script').appendTo('.tx-tp3-social')
$('iframe[src^="javascript"]').appendTo('.tx-tp3-social')

$('span.IN-widget').appendTo('.tx-tp3-social');

//	var docReady = $.Deferred();
//	var facebookReady = $.Deferred();
var businessviewCanvasSelector =  businessviewCanvasSelector || "#businessview-canvas",
	google = google || {},
	businessviewJson = businessviewJson || {},
	scrollTimeStart = new Date,
	disableStr = disableStr || false,
	WECInit = WECInit || undefined,
	$container = $container || undefined,
	greeting =  $j('#c1716').parents('div').first(),
	section_image = section_image || [],
	section_speed = section_speed || [];
$j(greeting).parents('.section-light').hide();
var section_box;
window.tp3_app = window.tp3_app || {};
window.$container = $container;

if($j(document).width() < 769){
	$j('.toolbar').insertAfter('header .navbar-toggle').addClass('ismobile')
}
else   {
	$j('.toolbar').insertBefore('.main-section')

}
var QueryString = function () {

	var query_string = {};
	var query = window.location.search.substring(1);
	var vars = query.split("&");

	for (var i = 0; i < vars.length; i++) {

		var pair = vars[i].split("=");

		if (typeof query_string[pair[0]] === "undefined") {

			query_string[pair[0]] = pair[1];

		} else if (typeof query_string[pair[0]] === "string") {

			var arr = [ query_string[pair[0]], pair[1] ];
			query_string[pair[0]] = arr;

		} else {

			query_string[pair[0]].push(pair[1]);

		}

	}
	if(window.location.hash && $(".page-" + window.location.hash.substring(1)).length > 0){
		//e.preventDefault();
		if($.type($.smoothScroll) == "function"){
			$.smoothScroll({
				scrollElement: null,
				scrollTarget: ".page-" + window.location.hash.substring(1)
			});
		}


		window.history.pushState({}, '', window.location.hash);
	} if(document.location.hash && $(".page-" + document.location.hash.substring(1)).length > 0){
		//e.preventDefault();
		if($.type($.smoothScroll) == "function"){
			$.smoothScroll({
				scrollElement: null,
				scrollTarget: ".page-" + document.location.hash.substring(1)
			});
		}


		window.history.pushState({}, '', document.location.hash);
	}else if($(window.location.hash).length > 0){
		//  e.preventDefault();

		if($.type($.smoothScroll) == "function"){
			$.smoothScroll({
				scrollElement: null,
				scrollTarget:  document.location.hash
			});
		}



		window.history.pushState({}, '', window.location.hash);
	}
	return query_string;

} ();

if(QueryString.businessviewId && QueryString.businessviewId != "") {

	businessviewId = QueryString.businessviewId;

}
var windowPadding = 10;
var bottomPadding = 80;
var wndW = window.availWidth- (windowPadding * 2);
var wndH = window.availHeight- (windowPadding * 2 );
$.each($('.tx-wecmap-map'),function(){
	wndW = $(this).parents(".container").width();
	wndH = $(this).parents(".container").height();
	$(this).css({"max-width":"100%","max-height":"100%"});
})
$( window ).on("resize",function() {
	var wndW = window.availWidth- (windowPadding * 2);
	var wndH = window.availHeight- (windowPadding * 2 );
	console.log("resize");
	if($(window).height()<769)
		$('iframe:not([id^="oauth2relay"]), .tx-wecmap-map').css({"max-width":"100%","max-height":"100%"});
	else{
		$.each($('iframe:not([id^="oauth2relay"]), .tx-wecmap-map'),function(){
			wndW = $(this).parents(".container").width();
			wndH = $(this).parents(".container").height();
			$(this).css({"max-width":"100%","max-height":"100%"});
		})
	}
});
var WECInit = WECInit || undefined, WecMap = WecMap || undefined;

tp3_app.initialize=function(){
	if(tp3_app.init == true)return;
	try{
		if (($j('.tx-wecmap-map').length > 0 || businessviewJson.hasDetails) &&( google.maps != undefined && $j.type(google.maps) == "object")){

			google.maps.event.addDomListener(window,"load", function () {
				if (  WECInit != undefined && $j.type(WECInit) == "function" ) {
					if($j.type( createWecMap) == "function")WECInit();
				}

				tp3_app.init = true;
				console.log(businessviewJson);

				if(businessviewJson.hasDetails && $j(businessviewCanvasSelector).length > 0){tp3_app.businessview_initialize(businessviewJson);}
				else{console.log(businessviewJson.errorMessage);}

				//  if(gapi && $j.type(gapi) == "object")  gapi.plus.go();
			});
			if ( WecMap == undefined)  tp3_app.init = true;


		}
		else  if ($j('.tx-wecmap-map').length < 1 && google == undefined){
			/*
            no google maps needed - so proceed
             */
			tp3_app.init = true;
		}
		if($j.type(tp3_app.privacyPopup) == "funtion" && !tp3_app.getCookieValue(disableStr)) tp3_app.privacyPopup();
		// #todo move to function list to call incl. callback
		if($j.type(tp3_app.controls) == "function")tp3_app.controls();
		if($j.type(tp3_app.parallax) == "function")tp3_app.parallax();
		if($j.type(tp3_app.isotop) == "function")tp3_app.isotop();
	}catch (e){
		console.log(e);
	}

};
tp3_app.cookies = tp3_app.cookies || true;
tp3_app.init = tp3_app.init || false;
var sl = 0,
	section_image = section_image || [];

tp3_app.backmove = function (e) {
	if (e == undefined) e = $j('body').first();
	if( $j('.section_image').length > 2) $j('.section_image').first().remove()
	if (section_image && $j.type(section_image) == "array" && section_image.length > 0 && section_image[0].background ) {
		var img = section_image[sl].background;
		//get the index of the start of the part of the URL we want to keep
		if( img.toLowerCase().match(/\.(jpeg|jpg|gif|png|svg)$/) != null)
		{
			if( $j('.section_shadow').length < 1){
				var shadow =  $j("<div>&nbsp;</div>").appendTo( $j('.body-bg').first())
				shadow.addClass("section_shadow").css({
					"position":"absolute",
					"width":"100%",
					"height":"100%",
					"z-index":"-1",
					"top":"0",
					"max-height":screen.availHeight,
				})
			}


			var gb =  $j("<div></div>").appendTo( $j('.body-bg').first())
			gb.addClass("section_image")
			gb.addClass("p" + $j(e).attr("id").split("-")[1]+"_"+sl)
				.attr("data-speed",section_speed[sl].speed != "" ? section_speed[sl].speed : -Math.floor((Math.random() * 10) + 1))
				.css({
					"position":"absolute",
					"width":"100%",
					"z-index":"-3",
					"height":$j(document).height()+"px",
					"display":"none",
					"top":0,
					"max-height":"100%",
					"background-position": "50% 0%",
					"background-image": "url(" + img + ")",
				})

		}
		else if ( img.toLowerCase().match(/\.(avi|mpg|flv|mov|mp4|ogg|flac|opus|webm|youtube|vimeo)$/) != null ){
			var gb =  $j("<video controls=\"\" class=\"embed-responsive-item\"><source src=\""+img+"\" type=\"video/mp4\"></video>").appendTo( $j('.body-bg').first())
			gb.addClass("section_image ")
				.addClass("section_video")
				.attr("data-speed",section_speed[sl].speed != "" ? section_speed[sl].speed : -Math.floor((Math.random() * 10) + 1))
				.css({
					"position":"absolute",
					"width":"100%",
					"height":$j(document).height()+"px",
					"display":"none",
					"top":0,
					"max-height":"100%",
					"background-position": "50% 0%",
					"background-image": "url(" + img + ")",

				})

		}
		gb.fadeIn("slow", function () {
			if( $j('.section_image').length > 1)   $j('.section_image').first().fadeOut("slow", function () {
			})
		})

		if($j.type(tp3_app.parallax == "function"))tp3_app.parallax();

		sl++;
		if (sl >= section_image.length) sl = 0;
		setTimeout(function () {
			tp3_app.backmove(e)
		}, 15000);
	}
	// else {
	//     sl++;
	//     if (sl >= section_image.length) sl = 0;
	//     tp3_app.backmove(e)
	// }


}
tp3_app.watchdog = function () {
	$j(document).on("loaded",function(){
		if(mobile != true) $j('.toolbar').slideDown();
		if(!tp3_app.init){
			tp3_app.initialize();
		}
		$j(".logo").animate({
			'opacity': '3'
		}, {
			step: function (now, fx) {
				//	$j(this).css({"transform": "translate3d(0px, " + now + "px, 0px)"});
				$j(this).css({'transform': 'rotateY( '+now * 120+'deg )'});

			},
			duration: 2000,
			easing: 'swing',
			queue: false,
			complete: function () {

				console.log('Animation is done box');
				if(!tp3_app.init){
					tp3_app.initialize();
				}
				else
				{
					if($j.type(WECInit) == "function" && google.maps != undefined)WECInit()
					// #todo move to function list to call incl. callback
					if($j.type(tp3_app.controls == "function"))tp3_app.controls();
					if($j.type(tp3_app.isotop == "function"))tp3_app.isotop();
					if($j.type(tp3_app.parallax == "function"))tp3_app.parallax();

				}


			}
		})

		if(tp3_app.flexsliders && $j.type($j.fn.flexslider=="function")){
			$j.flexslider = $j.flexslider || {};
			$j.flexslider.defaults = {
				namespace: "flex-",             //{NEW} String: Prefix string attached to the class of every element generated by the plugin
				selector: ".slides > li",       //{NEW} Selector: Must match a simple pattern. '{container} > {slide}' -- Ignore pattern at your own peril
				animation: "fade",              //String: Select your animation type, "fade" or "slide"
				easing: "swing",                //{NEW} String: Determines the easing method used in jQuery transitions. jQuery easing plugin is supported!
				direction: "horizontal",        //String: Select the sliding direction, "horizontal" or "vertical"
				reverse: false,                 //{NEW} Boolean: Reverse the animation direction
				animationLoop: true,            //Boolean: Should the animation loop? If false, directionNav will received "disable" classes at either end
				smoothHeight: false,            //{NEW} Boolean: Allow height of the slider to animate smoothly in horizontal mode
				startAt: 0,                     //Integer: The slide that the slider should start on. Array notation (0 = first slide)
				slideshow: true,                //Boolean: Animate slider automatically
				slideshowSpeed: 7000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
				animationSpeed: 600,            //Integer: Set the speed of animations, in milliseconds
				initDelay: 0,                   //{NEW} Integer: Set an initialization delay, in milliseconds
				randomize: false,               //Boolean: Randomize slide order
				fadeFirstSlide: true,           //Boolean: Fade in the first slide when animation type is "fade"
				thumbCaptions: false,           //Boolean: Whether or not to put captions on thumbnails when using the "thumbnails" controlNav.

				// Usability features
				pauseOnAction: true,            //Boolean: Pause the slideshow when interacting with control elements, highly recommended.
				pauseOnHover: false,            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
				pauseInvisible: true,   		//{NEW} Boolean: Pause the slideshow when tab is invisible, resume when visible. Provides better UX, lower CPU usage.
				useCSS: true,                   //{NEW} Boolean: Slider will use CSS3 transitions if available
				touch: true,                    //{NEW} Boolean: Allow touch swipe navigation of the slider on touch-enabled devices
				video: true,                   //{NEW} Boolean: If using video in the slider, will prevent CSS3 3D Transforms to avoid graphical glitches

				// Primary Controls
				controlNav: true,               //Boolean: Create navigation for paging control of each slide? Note: Leave true for manualControls usage
				directionNav: true,             //Boolean: Create navigation for previous/next navigation? (true/false)
				prevText: "Previous",           //String: Set the text for the "previous" directionNav item
				nextText: "Next",               //String: Set the text for the "next" directionNav item

				// Secondary Navigation
				keyboard: true,                 //Boolean: Allow slider navigating via keyboard left/right keys
				multipleKeyboard: false,        //{NEW} Boolean: Allow keyboard navigation to affect multiple sliders. Default behavior cuts out keyboard navigation with more than one slider present.
				mousewheel: false,              //{UPDATED} Boolean: Requires jquery.mousewheel.js (https://github.com/brandonaaron/jquery-mousewheel) - Allows slider navigating via mousewheel
				pausePlay: false,               //Boolean: Create pause/play dynamic element
				pauseText: "Pause",             //String: Set the text for the "pause" pausePlay item
				playText: "Play",               //String: Set the text for the "play" pausePlay item

				// Special properties
				controlsContainer: "",          //{UPDATED} jQuery Object/Selector: Declare which container the navigation elements should be appended too. Default container is the FlexSlider element. Example use would be $(".flexslider-container"). Property is ignored if given element is not found.
				manualControls: "",             //{UPDATED} jQuery Object/Selector: Declare custom control navigation. Examples would be $(".flex-control-nav li") or "#tabs-nav li img", etc. The number of elements in your controlNav should match the number of slides/tabs.
				customDirectionNav: "",         //{NEW} jQuery Object/Selector: Custom prev / next button. Must be two jQuery elements. In order to make the events work they have to have the classes "prev" and "next" (plus namespace)
				sync: "",                       //{NEW} Selector: Mirror the actions performed on this slider with another slider. Use with care.
				asNavFor: "",                   //{NEW} Selector: Internal property exposed for turning the slider into a thumbnail navigation for another slider

				// Carousel Options
				itemWidth: 0,                   //{NEW} Integer: Box-model width of individual carousel items, including horizontal borders and padding.
				itemMargin: 0,                  //{NEW} Integer: Margin between carousel items.
				minItems: 1,                    //{NEW} Integer: Minimum number of carousel items that should be visible. Items will resize fluidly when below this.
				maxItems: 0,                    //{NEW} Integer: Maxmimum number of carousel items that should be visible. Items will resize fluidly when above this limit.
				move: 0,                        //{NEW} Integer: Number of carousel items that should move on animation. If 0, slider will move all visible items.
				allowOneSlide: true,           //{NEW} Boolean: Whether or not to allow a slider comprised of a single slide

				// Callback API
				start: function(){
					//         if($j('.flex-active-slide').find("video").length>0) {
					//
					//             var active = $j('.flex-active-slide').find("video")[0];
					//             active.src = $j('.flex-active-slide').find("video").find("source").attr("src")
					//         }
				},            //Callback: function(slider) - Fires when the slider loads the first slide
				before: function(){
					//         if($j('.flex-active-slide').find("video").length>0) {
					//             $j('.flex-active-slide').find("button").on('click', function() {
					//                 $j('.flex-active-slide').find("video")[0].src = $j('.flex-active-slide').find("video").find("source").attr("src")
					//
					//             });
					//         }
					//
					$j('.flexslider').find("video").each(function() {
						var $vid = $j(this)[0];
						if ($vid.paused) {
							//already paused, do nothing
						} else {
							$vid.pause();
						}
					});
				},           //Callback: function(slider) - Fires asynchronously with each slider animation
				after: function(){
					if($j('.flex-active-slide').find("video").length>0){
						var active =$j('.flex-active-slide').find("video")[0];
						$j('.flex-active-slide').find("button").on('click', function() {
							$j('.flex-active-slide').find("video")[0].src = $j('.flex-active-slide').find("video").find("source").attr("src")

						});
						if (active.paused) {
							active.src = $j('.flex-active-slide').find("video").find("source").attr("src");
							active.autoplay = true;
							// var promise = active.play();
							//
							// if (promise !== undefined) {
							//     promise.then(_ => {
							//         console.log("autoplay")
							//     }).catch(error => {
							//        callback:$j('.flex-active-slide').find("button").trigger("click")
							//         });
							//             }
							// console.log('paused');
						}

					}
					try{
						$j('.flex-active-slide').find("img.lazyload").responsiveimage({}, function () {
							$j(this).load(function () {
								this.style.opacity = 1
							})
						})
					}
					catch(e){
						console.log(e)
					}
				},            //Callback: function(slider) - Fires after each slider animation completes
				end: function(){},              //Callback: function(slider) - Fires when the slider reaches the last slide (asynchronous)
				added: function(){},            //{NEW} Callback: function(slider) - Fires after a slide is added
				removed: function(){},           //{NEW} Callback: function(slider) - Fires after a slide is removed
				init: function() {

				}             //{NEW} Callback: function(slider) - Fires after the slider is initially setup
			};
			tp3_app.flexsliders();

		}
		$j(window).trigger("loaded")
	})
}
tp3_app.scriptsload = function(data){
	var data_txt = data;

	$j(data_txt.responseText).each(function(){
		if(this.tagName == "script" || this.tagName == "SCRIPT"){


			if(this.src != undefined){

				//if(!this.src.toString().match(/fileadmin\/script/g))
				//if(!this.src.toString().match(/app/g))
				if(this.src.toString().match(/fileadmin\/script/g).length < 1 && this.src.toString().match(/app.js/g).length < 1 && this.src.toString().match(/jquery/g).length < 1)loadScript(this.src)
				/* $j.getScript(this.src, function(datax, textStatus, jqxhr) {
                    console.log(this, datax); //data returned
                   var sc = $j('<script/>', {
                      language: 'JavaScript',
                   text: datax != undefined && datax != '' ? datax : '',
                    }).appendTo('head');
                    console.log(textStatus); //success
                    console.log(jqxhr.status); //200
                    console.log('Load was performed.');
                  });
                  console.log(this)  */
			}
			else{
				var str = $j(this).text();
				var regex = /window.history.back()/gi;
				var sc = $j('<script/>', {
					language: 'JavaScript',
					text: str.replace(regex, "<!-- cut -->")
				}).appendTo('head');
			}
		}

	})
}
tp3_app.watchdog();
tp3_app.isotop = function(){
	if($j.type($j.fn.isotope) == "function"){ var $container = $j('.product_listing.row').isotope({
		itemSelector: '.element-item',
		layoutMode: 'fitRows',
		getSortData: {
			image: '.image',
			category: '.category',
			number: '.products_price',
			category: '.products_name',

		}
	});
	}

	// filter functions
	var filterFns = {
		// show if number is greater than 50
		numberGreaterThan50: function() {
			var number = $j(this).find('.number').text();
			return parseInt( number, 10 ) > 50;
		},
		// show if name ends with -ium
		ium: function() {
			var name = $j(this).find('.name').text();
			return name.match( /ium$/ );
		}
	};

	// bind filter button click
	$j('#filters').on( 'click', 'button', function() {
		var filterValue = $j( this ).attr('data-filter');
		// use filterFn if matches value
		filterValue = filterFns[ filterValue ] || filterValue;
		$container.isotope({ filter: filterValue });
	});

	// bind sort button click
	$j('#sorts').on( 'click', 'button', function() {
		var sortByValue = $j(this).attr('data-sort-by');
		$container.isotope({ sortBy: sortByValue });
	});

	// change is-checked class on buttons
	$j('.button-group').each( function( i, buttonGroup ) {
		var $buttonGroup = $j( buttonGroup );
		$buttonGroup.on( 'click', 'button', function() {
			$buttonGroup.find('.is-checked').removeClass('is-checked');
			$j( this ).addClass('is-checked');
		});
	});
}
/*
cookieconsent integration
 */
tp3_app.privacyRequest = function(choise){
	var jqxhr = $.getJSON( '/index.php?eID=consent&choise=' + choise)
		.done(function () {
			console.log("done")
		})
		.fail(function () {
			console.log("error");
		})
		.always(function (result) {
			console.log(result);
		});

	return false;
};
tp3_app.getCookieValue = function(name) {
	var value = document.cookie;
	var cookieStartsAt = value.indexOf(" " + name + "=");
	if (cookieStartsAt == -1) {
		cookieStartsAt = value.indexOf(name + "=");
	}
	if (cookieStartsAt == -1) {
		value = null;
	} else {
		cookieStartsAt = value.indexOf("=", cookieStartsAt) + 1;
		var cookieEndsAt = value.indexOf(";", cookieStartsAt);
		if (cookieEndsAt == -1) {
			cookieEndsAt = value.length;
		}
		value = unescape(value.substring(cookieStartsAt,
			cookieEndsAt));
	}
	return value;
};
tp3_app.onpage = function(){



	$('.navbar-main a[href*="#"]:not(.dropdown-toggle), #logo').on('click', function(e) {
		console.log(e);
		if(this.hash && $(".page-" + this.hash.substring(1)).length > 0){
			$('.navbar-collapse.in').collapse('hide');
			$('html,body').animate({scrollTop: $(this.hash.substring(1))}, 500);
			if(ga){ ga('send','event','scroll',
				this.hash + ' Window: ' + $(window).height() + 'px; Document: ' + $(document).height() + 'px; Time: ' + Math.round((new Date - scrollTimeStart )/1000,1) + 's',
				{'nonInteraction':1}
			);
			}
			window.history.pushState({}, '', this.hash);
			e.preventDefault();
		}else if($(this.hash).length > 0){
			$('.navbar-collapse.in').collapse('hide');
			$('html,body').animate({scrollTop: $(this.hash)}, 500);
			if(ga){ ga('send','event','scroll',
				this.hash + ' Window: ' + $(window).height() + 'px; Document: ' + $(document).height() + 'px; Time: ' + Math.round((new Date - scrollTimeStart )/1000,1) + 's',
				{'nonInteraction':1}
			);
			}
			window.history.pushState({}, '', this.hash);
			e.preventDefault();
		}
		else if(this.hash.length > 0)
			document.location = "/"+ this.hash;

	});
};

/*
parallax effect
 */
$window = $j(window);
var tp3parallax = tp3parallax || false;
tp3_app.parallax = function(){
//.body-bg .section_image,
	if(!tp3parallax)return;
	$j(' .carousel-inner .item.active,  #content.main-section  > .section , #content.main-section  > .row.frame, .section_image').each(function(){
		// declare the variable to affect the defined data-type
		var $scroll = $(this);

		$window.on('scroll', function(){
			// HTML5 proves useful for helping with creating JS functions!
			// also, negative value because we're scrolling upwards
			var speed = $scroll.data('speed') != undefined ? $scroll.data('speed') : Math.floor((Math.random() * 10) + 1) ;
			var yPos = speed < 0 ? 0 -(($window.scrollTop() -  $scroll.offset().top) * speed / 100 ) : 0 -(($window.scrollTop() -  $scroll.offset().top) * speed / 100);// ($window.scrollTop() * 2);//

			// background position
			var coords = '50% '+ yPos + '%';

			// move the background
			$scroll.css({
				backgroundPosition: coords,

			})
			// if($scroll.hasClass("section_image")){
			//     $scroll.css({
			//         top: $scroll.offset().top + Math.round($scroll.offset().top * 0.25) +"px",
			//
			//     })
			// }

			//
		}); // end window scroll
	});  // end section function


	window.addEventListener('touchstart', function() {
		mobile = true;
	});

	(wresize = function() {
		msize = $j('.header').width();
		$j('.attached').width(msize);
	});

	// $j(document).scroll(scroll);
	// $j(window).resize(wresize);
	//$j('#content.main-section  > .section , #content.main-section  > .row.frame').css({"min-height":screen.height});
	//$j('#content.main-section').first().css({"min-height":screen.height});
//$j('body > .body-bg').attr("data-speed","6").css({"background-image":"url(fileadmin/user_upload/neodental/Technician-in-dental-lab-presenting-a-prosthesis-into-the-camera-000025618872_Double.jpg)"});
	$j(window).trigger("scroll")
};
//$j('.main-section > .section.section-light').attr("data-speed","3").css({"background-size":"cover;","background-image":"url(fileadmin/locations/LocationGuide-Titelbilder/ATELIERS-GALERIEN-documenta10_Seitenlichthalle__documenta_gGmbH.jpg)"});
$j('.body-bg').attr("data-speed","-50")

$j('.carousel-inner .item ').attr("data-speed","-9")

jQuery.fn.insertElementAtIndex=function(element,index){var lastIndex=this.children().length;
	if(index<0){index=Math.max(0,lastIndex+ 1+ index)}
	this.append(element)
	if(index<lastIndex){this.children().eq(index).before(this.children().last())}
	return this;}
var panorama;var panoJumpTimer;var panoRotationTimer;var panoResizeTimer;var panoResizeCounter=0;var businessviewSidebarModulesSelector='';var showSidebar=false;var startCoords={},endCoords={};var zoom=1;var updateInfoPointsStartTimer;var updateInfoPointsCounter=0;var $panoCanvas=null;var panoCanvasHeight=0;var panoCanvasWidth=0;

tp3_app.initcontrols = tp3_app.initcontrols || false;
tp3_app.controls = function(){

	if(tp3_app.init && tp3_app.initcontrols) return;


	var ts_style = ts_style || {border: false, mousespeed: 1.3, size:"500", smallestsize:8, biggestsize:22, clicktostart:true};

	$j('.tag-cloud').each(function(){
		var arr = $j(this).children();
		if(arr.length > 50){
			for (var i = arr.length - 1; i > 0; i--) {
				var j = Math.floor(Math.random() * (i + 1));
				var temp = arr[i];
				arr[i] = arr[j];
				arr[j] = temp;
			}
		}
		arr.splice(0,50);
		$j(this).replaceWith(arr);

		$tagsphere($j(this).parents('.news').get(0), ts_style);
	})
	$j('input[type="checkbox"]').each(function(){
		$j(this).insertBefore($j(this).parent('label'));
		$j(this).on("change", function(){$j(this).next("label").find("input").val($j(this).is(':checked') ? "checked" : "")})
	})
	$j('.ajaxModal, [data-toggle="ajaxModal"], #calendar-event a[href*="/koch-events/kulinarium/"]').not('.tp3rederer').on('click',
		function(e) {
			$j('#ajaxModal').remove();
			e.preventDefault();
			var $this = $j(this)
				, $remote = $this.data('src') ||   $this.attr('href').replace("/de/","/") + "?type=1000 #content"
				, $modal = $('<div class="modal fade" id="ajaxModal" tabindex="-1" role="dialog" aria-hidden="true">\n' +
				'  <div class="modal-dialog modal-lg">\n' +
				'    <div class="modal-content">\n' +
				'      <div class="modal-header">\n' +
				'        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\n' +
				'        <h4 class="modal-title" id="myModalLabel">'+$this.text()+'</h4>\n' +
				'      </div>\n' +
				'      <div class="modal-body"><div class="loader"></div>\n' +
				'        ...\n' +
				'      </div>\n' +
				'      <div class="modal-footer">\n' +
				'      </div>\n' +
				'    </div>\n' +
				'  </div>\n' +
				'</div>');

			$j('body').append($modal);
			$modal.modal({ keyboard: true});
			$modal.find(".modal-body").css({padding:"20px 10px 0 10px"}).load($remote , function () {
				$j('form[name="anfordern"]').autosubmit({
					"request": "data"
				});

				$modal.find('input[type="checkbox"]').each(function(){
					var tgt =  $j(this).prev('input[type="hidden"]');
					$j(this).insertBefore($j(this).parent('label')).on("change",function(){
						$j(tgt).val($j(this).val());
					})

				})
			});

			// Fill modal with content from link href
			$("#ajaxModal").on("show.bs.modal", function(e) {
				//var link = $(e.relatedTarget);
				//	$(this).find(".modal-body").load($remote+"?type=1000" );
			});
		}).addClass("tp3rederer").addClass("btn-primary");

	var boxes = [],
		pics = ["/fileadmin/user_upload/lacuisine/_migrated/pics/kuechendesign.png", "/fileadmin/user_upload/lacuisine/_migrated/pics/geraetetechnik.png", "/fileadmin/user_upload/lacuisine/_migrated/pics/veranstaltungen.png"],
		x = 0;
	$j.each($j('#c1719 ,#c1720,#c1721'),function(){
		if(!$j(this).parents('.col-sm-4').hasClass("slider")){
			slider = $j(this).parents('.col-sm-4').addClass('slider')
			slider.parent().css({
				width: '100%',
				//height: '230px',
				position: 'relative',
				perspective: '800px',
			})
			$j(this).find('.texticon-icon').parent('a').hide();
			boxes.push(this);

			var ref = $j(this).find('a').first().attr("href"),
				title = $j(this).find('a').first().attr("title"),
				src = pics[x],
				box = $j(this);

			$j(box).addClass('flexible').addClass('box')
			$j(box)
				.click(function(){
					location.href = ref;
				})
				.addClass('box')
				.css({
					'width': '100%',
					'margin':'0',
					'padding':'0',
					'border': 0,
					'cursor':'pointer'

				})
			$j('<figure/>',{
				class:"pic",
				border:0,}).appendTo(box).css({
				margin: 0,
				display: 'block',
				width: '100%',
				height: '100%',
				//  'transform-style': 'preserve-3d',
				//    'transition': 'transform 1s',
				'opacity': '1',

			})
			$j('<img/>',{

				class:"picimg back",
				src:src,

				border:0,
			}).appendTo($j(box).find("figure")).css({
				margin: 0,
				display: 'block',
				width: '100%',
				height: '100%',
			})
		}

		$j(document, window).on("loaded",function(){
			if(!tp3_app.init){
				tp3_app.initialize();
			}
			$j(box).toggleClass('flipped')
			$j(box).find('figure').animate({
				'opacity': '3'
			}, {
				step: function (now, fx) {
					//	$j(this).css({"transform": "translate3d(0px, " + now + "px, 0px)"});
					$j(box).find('.texticon-content').css({'transform': 'rotateX( '+now * 120+'deg )'});
					$j('.logo').css({'transform': 'rotateY( '+now * 120+'deg )'});
				},
				duration: 2000,
				easing: 'swing',
				queue: false,
				complete: function () {
					console.log('Animation is done box');
					tp3_app.controls();
					$j(window).trigger("scroll")


				}

			})

		})
		if(slider.lengt > 1){
			/*slider
                .css({
                    'overflow':'hidden',
                    'width': '100%',
                    'max-height': '330px',
                    'height': '230px',
                    'background':'#000',
                })
                */
		}
		x++;
	})
	if($j('.media-list').length > 0){
		var $sbtn = $j('<a href="JavaScript:return false;"><div class="texticon-icon texticon-size-default texticon-type-default"><span class="texticon-inner-icon glyphicon glyphicon-search" style="cursor: pointer;"></span></div></a>').css({ "position":"absolute","right": "10px","top": "10px"}),
			$sinp =  $j('<input class="form-control" id="media_search" type="text" name="media_search" value="">').insertBefore('.media-list').hide();

		$sbtn.insertBefore('.media-list').click(function(){
			var $rows = $j('li.media');
			$sinp.toggle();
			$sinp.focus();
			$sinp.keyup(function() {
				var val = $.trim($j(this).val()).replace(/ +/g, ' ').toLowerCase();

				$rows.show().filter(function() {
					var text = $j(this).text().replace(/\s+/g, ' ').toLowerCase();
					return !~text.indexOf(val);
				}).hide();
			});
		})

	}
	tp3_app.initcontrols = true;
	console.log("controls");
}

function onRequestCompleted(xhr,textStatus) {
	if (xhr.status == 302) {
		location.href = xhr.getResponseHeader("Location");
		console.log("302");
	}
}

var scroll, wresize, mobile = false;
var headerPos = $j('header .container').offset().top;
var once = true;
var init = false;

var show, go, scoll_pos;
var scroll_pos = scroll_pos || $j(document).scrollTop(),
	headerheight =   headerheight ||  $j('header.navbar').height()  ,
	headerwidth =   headerwidth ||  $j('header').width(),
	logoheight = logoheight || (headerheight ) + "px",
	logowidth  = logowidth ||   $j('#logo').width()< 1 ? $j('.navbar-brand-image').width() : $j('#logo').width() ,
	toolbarheight  = toolbarheight ||  $j('.toolbar').first().height();
if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
	|| /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) mobile = true;


(scroll = function(event) {
	if(headerwidth < 992){
		mobile = true;
		$j('body').addClass('ismobile');
		$j('.body-bg').css({"padding-top":0 + "px"});
		$j('header.navbar-top').width("100%").css({position:"relative",top:"0px","z-index":"99"});

	}
	else{
		mobile = false;
		$j('body').removeClass('ismobile');
		$j('.body-bg').css({"padding-top":headerheight + "px"});
		$j('header.navbar-top').width("100%").css({position:"fixed",top:"0px","z-index":"99"});
	}
	if(scroll_pos  == (headerPos)) {
		$j('header.navbar-top').addClass("toppos");

	}
	else{
		$j('header.navbar-top').removeClass("toppos");
	}
	if(mobile != true || headerwidth > 600) {
		var scrollPos = $j(document).scrollTop();
		if(scroll_pos  == (headerPos) || (scrollPos == headerPos)) {
			console.log("top")
			clearTimeout(go);
			//$j('header.navbar-top').height(100).css({position:"relative"});;

			//$j('header.navbar-top .container').removeClass('attached').css({'top' : '0px'});
			once = true;
			//$j('header.navbar-top .breadcrumb-section').hide();
			show = setTimeout(function() {
				$j(this).toggleClass('anim');
				$j('header.navbar-top').removeClass("flat");
				$j('a.navbar-brand-image, #logo, .logo').width( "auto").height(headerheight );
				//   $j('.navbar-collapse .nav > li > a, .headerslogan').css({"line-height": (headerheight - toolbarheight)  +"px"});
				//$j('.headerslogan').css({"padding-left":"140px"});

			}, 400);

			init = false;
		}

		if(scrollPos > headerPos && scroll_pos <= scrollPos) {
			clearTimeout(show);
			init = true;
			if(once === true) {
				once = false;

				go = setTimeout(function() {
					$j('header.navbar-top').addClass("flat");
					$j(this).toggleClass('anim');

					$j('a.navbar-brand-image, #logo, .logo').width( "auto").height(logoheight /2 );
				}, 400);
			}

			//$j('header.navbar-top').addClass('attached').css({'top' : (scrollPos-headerPos)+'px'});

		} else if(scrollPos < headerPos && scroll_pos >= scrollPos) {
			clearTimeout(show);
			init = true;
			if(once === true) {
				once = false;

				go = setTimeout(function() {
					$j(this).toggleClass('anim');
					$j('a.navbar-brand, a.navbar-brand img ,#logo, .logo').width( "auto").height(logoheight /2 );
					$j('header.navbar-top').removeClass("flat");
				}, 400);
			}

			//$j('header.navbar-top').addClass('attached').css({'top' : (scrollPos-headerPos)+'px'});

		} else if(init === true) {
			console.log("init")
			clearTimeout(go);
			once = true;
			//$j('header.navbar-top .breadcrumb-section').hide();
			show = setTimeout(function() {
				$j(this).addClass('anim');

			}, 400);

			init = false;
		}

		//scroll_pos = $j(document).scrollTop();
	}
	else if ( $j(window).width() < 992 ){
		$j('.toolbar').insertAfter('header .navbar-header-main');
		greeting.prependTo('#content')

		$j('a.navbar-brand, a.navbar-brand img ,#logo, .logo').width( "auto").height(logoheight );
		if($j('#logo').length > 0) $j(' a.navbar-brand img').hide()
		$j('header .container').first().height(headerheight);
		if(headerwidth < 992)$j('.toolbar').insertAfter('.navbar-toggle').addClass('ismobile');
		$j('body').addClass('ismobile');
		/*
        turn for mobile divice navigation
         */
		var section_panel = $j('.main-section > .section .row').first();
		section_panel.find('.subcontent-wrap').appendTo(section_panel);
		section_panel.find('.subnav-wrap').appendTo(section_panel);
		init = true;
	}

})();
$j(document).scroll(scroll);
$j(document).resize(scroll);
$j.fn.autosubmit = function(options) {

	$j.extend(this, options);
	$j(this).on("submit",function(event) {
		var form = $j(this);
		$j.ajaxSetup({complete: onRequestCompleted});
		var values = $j(form).find('select')
			.add(  $j(form).find('input[type!=checkbox]') )
			.add(  $j(form).find('textarea') )
			.serialize();
		// add values for checked and unchecked checkboxes fields
		$j(form).find('input[type=checkbox]').each(function() {
			var chkVal = $j(this).is(':checked') ? $j(this).val() : "0";
			values += "&" + $j(this).attr('name') + "=" + chkVal;
		});
		$j(form).find('input[type="file"]').each(function() {	 values += "&" + $j(this).attr('name') + "=" + $j(this).val()});

		$j.ajax({
			type: form.attr('method'),
			url: form.attr('action').toString(),
			data: values,
			async: true,
			success: function(data) {
				console.log(data);
				form.hide();
				$j(data).insertAfter(form);
				// tp3_app.scriptsload(data);
				$j(document).trigger("loaded");

			},
		}).done(function() {
			// Optionally alert the user of success here...
			//$j('#col3_content').html($j(event.target).html())
			//  $j(document).trigger("loaded");

		}).fail(function() {
			// Optionally alert the user of an error here...
			alert('error')
		});
		event.preventDefault();
	});
}

$.fn.serializeWithChkBox = function() {
	// perform a serialize form the non-checkbox fields
	var values = $(this).find('select')
		.add(  $(this).find('input[type!=checkbox]') )
		.add(  $(this).find('textarea') )
		.serialize();
	// add values for checked and unchecked checkboxes fields
	$(this).find('input[type=checkbox]').each(function() {
		var chkVal = $(this).is(':checked') ? $(this).val() : "0";
		values += "&" + $(this).attr('name') + "=" + chkVal;
	});
	$(this).find('input[name="cmd"]').each(function() {	 values += "&" + $(this).attr('name') + "=" + $(this).val()})
	return values;
}

var canvasDots = function() {
	//   var canvas = $j('.connecting-dots').length < 1 ? $j('<canvas class="connecting-dots"></canvas>').prependTo($('#content').first()).hide() : $j('.connecting-dots');
	var canvas = document.querySelector('canvas'),
		ctx = canvas.getContext('2d'),
		colorDot = 'rgba(2,2,2,0.1)',
		color = '#ccc';
	canvas.width = window.innerWidth;
	canvas.height = window.innerHeight;
	canvas.style.display = 'block';
	ctx.fillStyle = colorDot;
	ctx.lineWidth = .1;
	ctx.strokeStyle = color;

	var mousePosition = {
		x: 30 * canvas.width / 100,
		y: 30 * canvas.height / 100
	};

	var dots = {
		nb: 600,
		distance: 60,
		d_radius: 100,
		array: []
	};

	function Dot(){
		this.x = Math.random() * canvas.width;
		this.y = Math.random() * canvas.height;

		this.vx = -.5 + Math.random();
		this.vy = -.5 + Math.random();

		this.radius = Math.random();
	}

	Dot.prototype = {
		create: function(){
			ctx.beginPath();
			ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2, false);
			ctx.fill();
		},

		animate: function(){
			for(i = 0; i < dots.nb; i++){

				var dot = dots.array[i];

				if(dot.y < 0 || dot.y > canvas.height){
					dot.vx = dot.vx;
					dot.vy = - dot.vy;
				}
				else if(dot.x < 0 || dot.x > canvas.width){
					dot.vx = - dot.vx;
					dot.vy = dot.vy;
				}
				dot.x += dot.vx;
				dot.y += dot.vy;
			}
		},

		line: function(){
			for(i = 0; i < dots.nb; i++){
				for(j = 0; j < dots.nb; j++){
					i_dot = dots.array[i];
					j_dot = dots.array[j];

					if((i_dot.x - j_dot.x) < dots.distance && (i_dot.y - j_dot.y) < dots.distance && (i_dot.x - j_dot.x) > - dots.distance && (i_dot.y - j_dot.y) > - dots.distance){
						if((i_dot.x - mousePosition.x) < dots.d_radius && (i_dot.y - mousePosition.y) < dots.d_radius && (i_dot.x - mousePosition.x) > - dots.d_radius && (i_dot.y - mousePosition.y) > - dots.d_radius){
							ctx.beginPath();
							ctx.moveTo(i_dot.x, i_dot.y);
							ctx.lineTo(j_dot.x, j_dot.y);
							ctx.stroke();
							ctx.closePath();
						}
					}
				}
			}
		}
	};

	function createDots(){
		ctx.clearRect(0, 0, canvas.width, canvas.height);
		for(i = 0; i < dots.nb; i++){
			dots.array.push(new Dot());
			dot = dots.array[i];

			dot.create();
		}

		dot.line();
		dot.animate();
	}

	window.onmousemove = function(parameter) {
		mousePosition.x = parameter.pageX;
		mousePosition.y = parameter.pageY;
	}

	mousePosition.x = window.innerWidth / 2;
	mousePosition.y = window.innerHeight / 2;

	setInterval(createDots, 1000/30);
};



$j(document).promise().done(function( ) {

	console.log("promise");
	tp3_app.init = tp3_app.ini || false;
	if($j.type(tp3_app.backmove) == "function")tp3_app.backmove();

	try {
		var evt = new Event('loaded');
		window.dispatchEvent(evt);
		$j(document).trigger('loaded');

	}
	catch (e) {
		/*  var evt = document.createEvent('Event');
          window.dispatchEvent( evt);
          evt.initEvent("loaded", true, true);
          */
		$j(document).trigger('loaded');

	}
});

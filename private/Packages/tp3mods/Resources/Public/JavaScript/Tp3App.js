/***************************************************************
 *  Copyright notice
 *
 * tp3
 * 23.12.2018 thomas ruta
 ****************************************************************/

window.tp3_app = window.tp3_app || {};

/*
components for fe renderings
 */
tp3_app.compomemts= tp3_app.compomemts || [];

$ = $j = jQuery.noConflict();

tp3_app.cookies = tp3_app.cookies || true;
tp3_app.init = tp3_app.init || false;


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


var sl = 0,
    section_image = section_image || [];
tp3_app.compomemts["backmove"] = function (e) {
    if (e == undefined) e = $j('body').first();
    if( $j('.section_image').length > 2) $j('.section_image').first().remove()
    if (section_image && $j.type(section_image) == "array" && section_image.length > 0 && section_image[0].background) {
        var img = section_image[sl].background;
        //get the index of the start of the part of the URL we want to keep
        if( img.match(/\.(jpeg|jpg|gif|png|svg)$/) != null)
        {
            if( $j('.section_shadow').length < 1){
                var shadow =  $j("<div>&nbsp;</div>").appendTo( $j('.body-bg').first())
                shadow.addClass("section_shadow").css({
                    "position":"absolute",
                    "width":"100%",
                    "min-height":"100%",
                    "z-index":"-1",
                    "top":"0",
                    "max-height":screen.height,
                })
            }


            var gb =  $j("<div></div>").appendTo( $j('.body-bg').first())
            gb.addClass("section_image")
            gb.addClass("p" + $j(e).attr("id").split("-")[1]+"_"+sl)
                .attr("data-speed","-3")
                .css({
                    "position":"absolute",
                    "width":"100%",
                    "z-index":"-3",
                    "height":screen.height,
                    "min-height":"100%",
                    "display":"none",
                    "top":0,
                    "background-position": "50% 50%",
                    "background-image": "url(" + img + ")",
                    "background":"h-repeat"
                })

        }
        else{
            gb = $j('.body-bg').first().prepend($("<video controls=\"\" class=\"embed-responsive-item\"><source src=\""+img+"\" type=\"video/mp4\"></video>").css({
                    "position":"absolute",
                    "width":"100%",
                    "top":0,
                    "display":"none",
                    "height":"100%",
                    "background-image": "url(" + img + ")",
                    "background":"h-repeat"

                })
            )
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
}

/*
parallax effect
 */
$window = $j(window);

tp3_app.parallax = function(){
//.body-bg .section_image,
    $j(' .carousel-inner .item.active,  #content.main-section  > .section , #content.main-section  > .row.frame, .section_image').each(function(){
        // declare the variable to affect the defined data-type
        var $scroll = $(this);

        $window.on('scroll', function(){
            // HTML5 proves useful for helping with creating JS functions!
            // also, negative value because we're scrolling upwards
            var speed = $scroll.data('speed') != undefined ? $scroll.data('speed') : Math.floor((Math.random() * 10) + 1) ;
            var yPos = speed < 0 ? 50 -(($window.scrollTop() -  $scroll.offset().top) * speed / 100 ) : 50 -(($window.scrollTop() -  $scroll.offset().top) * speed / 100);// ($window.scrollTop() * 2);//

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
    //  $(window).trigger("scroll")

//$j('.main-section > .section.section-light').attr("data-speed","3").css({"background-size":"cover;","background-image":"url(fileadmin/locations/LocationGuide-Titelbilder/ATELIERS-GALERIEN-documenta10_Seitenlichthalle__documenta_gGmbH.jpg)"});
    $j('.body-bg').attr("data-speed","-50")

    $j('.carousel-inner .item ').attr("data-speed","-9")

};
/*
isotop lising effect
 */
tp3_app.isotop = function( selector){
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


tp3_app.watchdog();

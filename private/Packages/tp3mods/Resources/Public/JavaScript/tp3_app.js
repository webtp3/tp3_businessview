$ = $j = jQuery.noConflict();
var windowPadding = 10;
var bottomPadding = 80;

$('iframe[src^="javascript"]').prev('script').appendTo('.tx-tp3-social')
$('iframe[src^="javascript"]').appendTo('.tx-tp3-social')
$('span.IN-widget').appendTo('.tx-tp3-social');
var wndW = window.width- windowPadding * 2 * 0.9;
var wndH = window.height- windowPadding * 2 - bottomPadding;
//	var docReady = $.Deferred();
//	var facebookReady = $.Deferred();
var businessviewCanvasSelector =  businessviewCanvasSelector || "#businessview-canvas",
    google = google || {},
    businessviewJson = businessviewJson || {},
    scrollTimeStart = new Date,
    disableStr = disableStr || false,
    WECInit = WECInit || undefined;
window.tp3_app = window.tp3_app || {};


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
$( window ).on("resize",function() {
    wndW = $(window).width()- windowPadding * 2 * 0.9;
    wndH = $(window).height()- windowPadding * 2 - bottomPadding;
    console.log("resize")
    if($(window).height()<760)
        $('iframe:not([id^="oauth2relay"]), .tx-wecmap-map').css({"width":wndW+"px","height":wndH+"px","max-width":"100%","max-height":"100%"});
    else{
        $.each($('iframe:not([id^="oauth2relay"]), .tx-wecmap-map'),function(){
            wndW = $(this).parents(".container").width();
            wndH = $(this).parents(".container").height()
            $(this).css({"width":wndW+"px","height":wndH+"px","max-width":"100%","max-height":"100%"});
        })
    }
});
var WECInit = WECInit || {}, WecMap = WecMap || undefined;

tp3_app.initialize=function(){
    if(tp3_app.init == true)return;
    try{
        if ( google.maps != undefined && $j.type(google.maps) == "object"){

            google.maps.event.addDomListener(window,"load", function () {
                if (  WECInit != undefined && $j.type(WECInit) == "function") WECInit();

                tp3_app.init = true;
                console.log(businessviewJson);

                if(businessviewJson.hasDetails &&$j(businessviewCanvasSelector).length > 0){tp3_app.businessview_initialize(businessviewJson);}
                else{console.log(businessviewJson.errorMessage);}

                //  if(gapi && $j.type(gapi) == "object")  gapi.plus.go();
            })
            if ( WECInit == undefined)  tp3_app.init = true;


        }
        if(!tp3_app.getCookieValue(disableStr)) tp3_app.privacyPopup();
        if($j.type(tp3_app.controls == "function"))tp3_app.controls();

    }catch (e){
        console.log(e);
    }

};
tp3_app.cookies = tp3_app.cookies || true;
tp3_app.init = tp3_app.init || false;
var sl = 0,
    section_image = section_image || false;
tp3_app.backmove= function(e){
    if(e == undefined)e = $j('body').first();
    if(section_image["section#p" + $j(e).attr("id").split("-")[1]].length > 0 && section_image["section#p" + $j(e).attr("id").split("-")[1]][sl].background != ""){
        $j("#" + $j(e).attr("id") +" > .body-bg").css({"background-image":"url("+section_image["section#p" + $j(e).attr("id").split("-")[1]][sl].background+")","background-size":"cover"})
        /*$j("#" + $j(e).attr("id") +" > .body-bg").fadeTo('slow', 0.3, function(){
            $j(this).css('background-image', 'url(' + section_image["section#p" + $j(e).attr("id").split("-")[1]][sl].background + ')');
        }).fadeTo('slow', 1);	*/
        sl++;
        if(sl >= section_image["section#p" + $j(e).attr("id").split("-")[1]].length) sl = 0;
        setTimeout(function(){tp3_app.backmove(e)},  15000);
    }
}
tp3_app.initcontrols = tp3_app.initcontrols || false;
tp3_app.controls = function(){
    if(tp3_app.init && tp3_app.initcontrols) return;
    $j('input[type="checkbox"]').each(function(){
        $j(this).insertBefore($j(this).parent('label'));
        $j(this).on("change", function(){$j(this).next("label").find("input").val($j(this).is(':checked') ? "checked" : "")})
    })
    $j('.news').on('click', '.page-navigation a', function (e) {
        var ajaxUrl = $j(this).data('link');
        if (ajaxUrl !== undefined && ajaxUrl !== '') {
            e.preventDefault();
            var container = 'news-container-' + $j(this).data('container');
            $j.ajax({
                url: ajaxUrl.replace("http:", "https:"),
                type: 'GET',
                success: function (result) {
                    var ajaxDom = $j(result).find('#' + container);
                    $('#' + container).replaceWith(ajaxDom);
                }
            });
        }
    });

    $j('.ajaxModal, [data-toggle="ajaxModal"]').not('.tp3rederer').on('click',
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
        x = 0;
    $j('#c582').appendTo($j('.main-section .container').first())
    $j.each($j('#c582 li'),function(){
        boxes.push(this);
        var ref = $j(this).find('a').first().attr("href"),
            title = $j(this).find('a').first().attr("title"),
            box = $j(this);
        if(document.location.href == ref)$j(box).addClass('active')
        $j(box).addClass('flexible').addClass('box')
        $j(box)
            .click(function(){
                location.href = ref;
            })
            .addClass('box')
            .css({

                'cursor':'pointer'

            })

        x++;
    })
    if($j.type($j.fn.isotope) == "function"){
        var $container = $j('#c582 ul').isotope({
            itemSelector: 'li',
            layoutMode: 'fitRows',
            // getSortData: {
            //     image: '.image',
            //     category: '.category',
            //     number: '.products_price',
            //     category: '.products_name',
            //
            // }
        });
    }
    if($j('.media-list').length > 0){
        var $sbtn = $j('<a href="JavaScript:return false;"><div class="texticon-icon texticon-size-default texticon-type-default"><span class="texticon-inner-icon glyphicon glyphicon-search" style="cursor: pointer;"></span></div></a>').css({ "position":"absolute","right": "10px"}),
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
// $j(window).trigger("loaded");
    tp3_app.initcontrols = true;
    console.log("controls");
}




$j(document).on("loaded",function(){
    $j('.toolbar').insertAfter('header .navbar-header-main');//.navbar-collapse.collapse
    if(headerwidth < 992)$j('.toolbar').insertAfter('.navbar-toggle')
    $j('.toolbar').slideDown().css({display:"inline-flex"});
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
            tp3_app.controls();

            // tp3_app.isotop();
            //   tp3_app.parallax();
        }
    })

    if(tp3_app.flexsliders && $j.type($.flexslider=="function")){
        $.flexslider.defaults = {
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
            video: false,                   //{NEW} Boolean: If using video in the slider, will prevent CSS3 3D Transforms to avoid graphical glitches

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
                if($j('.flex-active-slide').find("video").length>0) {

                    var active = $j('.flex-active-slide').find("video")[0];
                    active.src = $j('.flex-active-slide').find("video").find("source").attr("src")
                }
            },            //Callback: function(slider) - Fires when the slider loads the first slide
            before: function(){
                if($j('.flex-active-slide').find("video").length>0) {
                    $j('.flex-active-slide').find("button").on('click', function() {
                        $j('.flex-active-slide').find("video")[0].src = $j('.flex-active-slide').find("video").find("source").attr("src")

                    });
                }

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
                        //     });
                        // }
                        // console.log('paused');
                    }
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

    setTimeout(function() {
        $j('document').trigger('scroll');
    }, 900);
});
var scroll, wresize, mobile = false;
var headerPos = $j('header .container').offset().top;
var once = true;
var init = false;

var show, go, scoll_pos;
var scroll_pos = $j(document).scrollTop(),
    headerheight = headerheight || $j('header').height(),
    headerwidth = headerwidth || $j('header').width(),
    logoheight = logoheight || $j('#logo').height(),
    logowidth = logowidth || $j('#logo').width(),
    toolbarheight = toolbarheight || $j('.toolbar').first().height();
if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) mobile = true;
if(headerwidth < 992){
    $j('body').addClass('ismobile');
    mobile = true;
}
else
    $j('body').removeClass('ismobile');

(scroll = function(event) {
    if(scroll_pos  == (headerPos)) {
        $j('header.navbar-top').addClass("toppos");

    }
    else{
        $j('header.navbar-top').removeClass("toppos");
    }

    if(mobile != true || headerwidth > 600) {
        var scrollPos = $j(document).scrollTop();
        if(scroll_pos  == (headerPos) || (scrollPos == headerPos)) {

            clearTimeout(go);

            //$j('header.navbar-top .container').removeClass('attached').css({'top' : '0px'});
            once = true;
            //$j('header.navbar-top .breadcrumb-section').hide();
            show = setTimeout(function() {
                $j('.body-bg').css({paddingTop:headerheight});
                $j('header.navbar-top').height(headerheight).css({position:"fixed",top:"0px","z-index":"999","width":"100%"});
                $j('.toolbar .frame').css({padding:"8px 0"});
                $j(this).toggleClass('anim');
                $j('header.navbar-top').removeClass("flat");
                $j(' a.navbar-brand-image, #logo').height(headerheight );
                //   $j('.navbar-collapse .nav > li > a, .headerslogan').css({"line-height": (headerheight - toolbarheight) *0.7   +"px"});
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
                    $j('.toolbar .frame').css({"padding":"4px 0"});

                    $j('header.navbar-top').height(headerheight ).width("100%").css({position:"fixed",top:"0px","z-index":"999"});
                    $j(' a.navbar-brand-image, #logo').height(headerheight  );
                    //      $j('.navbar-collapse .nav > li > a, .headerslogan').css({"line-height": (headerheight - toolbarheight) / 2  +"px"});
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
                    $j('header.navbar-top').addClass("flat");

                    $j('header.navbar-top').height(headerheight ).width("100%").css({position:"fixed",top:"0px","z-index":"999"});
                    $j('.toolbar .frame').css({padding:"4px 0"});
                    $j(' a.navbar-brand-image, #logo').height(headerheight);
                    //      $j('.navbar-collapse .nav > li > a, .headerslogan').css({"line-height": (headerheight - toolbarheight) /2 + "px"});
                    $j('header.navbar-top').removeClass("flat");
                }, 400);
            }

            //$j('header.navbar-top').addClass('attached').css({'top' : (scrollPos-headerPos)+'px'});

        } else if(init === true) {
            clearTimeout(go);
            once = true;
            //$j('header.navbar-top .breadcrumb-section').hide();
            show = setTimeout(function() {
                $j(this).addClass('anim');
                $j('.body-bg').css({paddingTop:headerheight*1.5});
            }, 400);

            init = false;
        }

        //scroll_pos = $j(document).scrollTop();
    }
    else if ( $j(window).width() < 1025 ){
        // headerheight = 100 ;

        $j('.toolbar').insertAfter('header .navbar-header-main');//.navbar-collapse.collapse
        //   $j('a.navbar-brand-image, #logo').width(headerwidth < 992 ? (logoheight/headerheight)*logowidth : (logoheight/headerheight)*logowidth * 0.7);
        // $j('header.navbar-top').first().height(headerheight /2);
        if(headerwidth < 992)$j('.toolbar').insertAfter('.navbar-toggle').addClass('ismobile');

        if(mobile)$j('.body-bg').css({paddingTop:headerheight});
        //    $j('header.navbar-top').height(headerheight).width("100%").css({position:"fixed",top:"0px","z-index":"99"});
        //   $j('#content').first().css({"margin-top":headerheight + "px"});
        /*
        turn for mobile divice navigation
         */
        var section_panel = $j('.main-section > .section .row').first();
        section_panel.find('.subcontent-wrap').appendTo(section_panel);
        section_panel.find('.subnav-wrap').appendTo(section_panel);
        init = true;
    }

    if($j('.flex-active-slide').find("video").length > 1 && $j('.flex-active-slide').find("video")[0].src != $j('.flex-active-slide').find("video").find("source").attr("src")) {
        $j('.flex-active-slide').find("video")[0].src = $j('.flex-active-slide').find("video").find("source").attr("src")
        // var promise =$j('.flex-active-slide').find("video")[0].play();
        //
        // if (promise !== undefined) {
        //     promise.then(_ => {
        //         console.log("autoplay")
        //     }).catch(error => {
        //          console.warn("autoplay error")
        //         $j('.flex-active-slide').find("button").trigger("click");
        //     });
        // }
    }



})();

tp3_app.cookies = tp3_app.cookies || true;

tp3_app.watchdog = function () {
    $j(document).on("loaded",function(){
        if(!tp3_app.init){
            tp3_app.initialize();


        }
        tp3_app.isotop();
        tp3_app.controls();

        $j(document).scroll(scroll);
        $j(document).resize(scroll);
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
    var jqxhr = $.getJSON( 'index.php?eID=consent&choise=' + choise)
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
}
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
}
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
$window = $j(window);
/*
parallax effect
 */
tp3_app.parallax = function(){

    $j('.body-bg .section_image, .carousel-inner .item,  #content.main-section  > .section , #content.main-section  > .row.frame').each(function(){
        // declare the variable to affect the defined data-type
        var $scroll = $(this);

        $window.on('scroll', function(){
            // HTML5 proves useful for helping with creating JS functions!
            // also, negative value because we're scrolling upwards
            var speed = $scroll.data('speed') != undefined ? $scroll.data('speed') : 5;
            var yPos =-(($window.scrollTop() - $scroll.offset().top) / speed);// ($window.scrollTop() * 2);//

            // background position
            var coords = '50% '+ yPos + 'px';

            // move the background
            $scroll.css({ backgroundPosition: coords, top : yPos+"px"  });
        }); // end window scroll
    });  // end section function


    window.addEventListener('touchstart', function() {
        mobile = true;
    });

    (wresize = function() {
        msize = $j('.header').width();
        $j('.attached').width(msize);
    });

    $j(document).scroll(scroll);
    $j(window).resize(wresize);
    $j('#content.main-section  > .section , #content.main-section  > .row.frame').css({"min-height":screen.height});
    $j('#content.main-section').first().css({"min-height":screen.height});
//$j('body > .body-bg').attr("data-speed","6").css({"background-image":"url(fileadmin/user_upload/neodental/Technician-in-dental-lab-presenting-a-prosthesis-into-the-camera-000025618872_Double.jpg)"});
    $(window).trigger("scroll")
};
jQuery.fn.insertElementAtIndex=function(element,index){var lastIndex=this.children().length;
    if(index<0){index=Math.max(0,lastIndex+ 1+ index)}
    this.append(element)
    if(index<lastIndex){this.children().eq(index).before(this.children().last())}
    return this;}
var panorama;var panoJumpTimer;var panoRotationTimer;var panoResizeTimer;var panoResizeCounter=0;var businessviewSidebarModulesSelector='';var showSidebar=false;var startCoords={},endCoords={};var zoom=1;var updateInfoPointsStartTimer;var updateInfoPointsCounter=0;var $panoCanvas=null;var panoCanvasHeight=0;var panoCanvasWidth=0;


tp3_app.controls = tp3_app.controls || function () {
    $j('input[type="checkbox"]').each(function(){
        $j(this).insertBefore($j(this).parent('label'));
        $j(this).on("change", function(){$j(this).next("label").find("input").val($j(this).is(':checked') ? "checked" : "")})
    })

    if(!tp3_app.getCookieValue(disableStr)){
       if( $j.type("recordOutboundLink") == "function" ){
           $j. recordOutboundLink();
       }
    }

    $j('.ajaxModal, [data-toggle="ajaxModal"]').on('click',
        function(e) {
            $j('#ajaxModal').remove();
            e.preventDefault();
            var $this = $j(this)
                , $remote = $this.data('src') || $this.attr('href') + "?type=1000 #content"
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
        }).addClass("btn-default");

    $(window).trigger("scroll");

    console.log("controls");
}



function onRequestCompleted(xhr,textStatus) {
    if (xhr.status == 302) {
        location.href = xhr.getResponseHeader("Location");
        console.log("302");
    }
}

$j.fn.autosubmit = function(options) {

    $j.extend(this, options)
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
        $j(form).find('input[type="file"]').each(function() {	 values += "&" + $j(this).attr('name') + "=" + $j(this).val()})

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
    /*

jQuery(window).load(function() {

    var w_width, w_height, largeHeader, canvas, ctx, points, target, animateHeader = true;

    // Main
    largeHeader = jQuery( '.home #msb-tweenlite-header');
    if ( jQuery( largeHeader ).height() > 0 ) {
       initHeader();
       initAnimation();
       addListeners();
    } else { return; }

    function initHeader() {

        w_height = jQuery( largeHeader ).height();
        w_width  = jQuery( largeHeader ).width();
        target = {x: w_width/2, y: w_height/2};
        // console.log( w_height);

        canvas = jQuery('<canvas/>',{ 'class':'radHuh', id: 'msb_canvas_314'
                }).prop({
                    width: w_width,
                    height: w_height
                });
        jQuery('#msb-tweenlite-header .et-pb-active-slide .et_parallax_bg').prepend(canvas);

        canvas.width = w_width;
        canvas.height = w_height;
        ctx = canvas[0].getContext('2d');

        // create points
        points = [];
        for(var x = 0; x < w_width; x = x + w_width/15) {
            for(var y = 0; y < w_height; y = y + w_height/15) {
                var px = x + Math.random()*w_width/15;
                var py = y + Math.random()*w_height/15;
                var p = {x: px, originX: px, y: py, originY: py };
                points.push(p);
            }
        }

        // for each point find the 5 closest points
        for(var i = 0; i < points.length; i++) {
            var closest = [];
            var p1 = points[i];
            for(var j = 0; j < points.length; j++) {
                var p2 = points[j]
                if(!(p1 == p2)) {
                    var placed = false;
                    for(var k = 0; k < 5; k++) {
                        if(!placed) {
                            if(closest[k] == undefined) {
                                closest[k] = p2;
                                placed = true;
                            }
                        }
                    }

                    for(var k = 0; k < 5; k++) {
                        if(!placed) {
                            if(getDistance(p1, p2) < getDistance(p1, closest[k])) {
                                closest[k] = p2;
                                placed = true;
                            }
                        }
                    }
                }
            }
            p1.closest = closest;
        }

        // assign a circle to each point
        for(var i in points) {
            //rgba(255,255,255,0.7)
            var c = new Circle(points[i], 2+Math.random()*2, 'rgba(116,199,168,0.7)');
            points[i].circle = c;
        }
    }

    // Event handling
    function addListeners() {
        if(!('ontouchstart' in window)) {
            window.addEventListener('mousemove', mouseMove);
        }
        window.addEventListener('scroll', scrollCheck);
        window.addEventListener('resize', resize);
    }

    function mouseMove(e) {
        var posx = posy = 0;
        if (e.pageX || e.pageY) {
            posx = e.pageX;
            posy = e.pageY;
        }
        else if (e.clientX || e.clientY)    {
            posx = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
            posy = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
        }
        target.x = posx;
        target.y = posy;
    }

    function scrollCheck() {
        if(document.body.scrollTop > w_height) animateHeader = false;
        else animateHeader = true;
    }

    function resize() {
        // largeHeader.style.height = w_height+'px';
        largeHeader = jQuery( '.home #msb-tweenlite-header');
        w_height = jQuery( largeHeader ).height();
        w_width  = jQuery( largeHeader ).width();
        target = {x: w_width/2, y: w_height/2};

        jQuery(canvas).prop({
                    width: w_width,
                    height: w_height
                });
        canvas.width = w_width;
        canvas.height = w_height;
        ctx = canvas[0].getContext('2d');


    }

    // animation
    function initAnimation() {
        animate();
        for(var i in points) {
            shiftPoint(points[i]);
        }
    }

    function animate() {
        if(animateHeader) {
            ctx.clearRect(0,0,w_width,w_height);
            for(var i in points) {
                // detect points in range
                if(Math.abs(getDistance(target, points[i])) < 4000) {
                    points[i].active = 0.3;
                    points[i].circle.active = 0.7;
                } else if(Math.abs(getDistance(target, points[i])) < 20000) {
                    points[i].active = 0.1;
                    points[i].circle.active = 0.3;
                } else if(Math.abs(getDistance(target, points[i])) < 40000) {
                    points[i].active = 0.02;
                    points[i].circle.active = 0.1;
                } else {
                    points[i].active = 0;
                    points[i].circle.active = 0;
                }

                drawLines(points[i]);
                points[i].circle.draw();
            }
        }
        requestAnimationFrame(animate);
    }

    function shiftPoint(p) {
        TweenLite.to(p, 1+1*Math.random(), {x:p.originX-50+Math.random()*100,
            y: p.originY-50+Math.random()*100, ease:Circ.easeInOut,
            onComplete: function() {
                shiftPoint(p);
            }});
    }

    // Canvas manipulation
    function drawLines(p) {
        if(!p.active) return;
        for(var i in p.closest) {
            ctx.beginPath();
            ctx.moveTo(p.x, p.y);
            ctx.lineTo(p.closest[i].x, p.closest[i].y);
            ctx.strokeStyle = 'rgba(255,255,255,'+ p.active+')';
            ctx.stroke();
        }
    }

    function Circle(pos,rad,color) {
        var _this = this;

        // constructor
        (function() {
            _this.pos = pos || null;
            _this.radius = rad || null;
            _this.color = color || null;
        })();

        this.draw = function() {
            if(!_this.active) return;
            ctx.beginPath();
            ctx.arc(_this.pos.x, _this.pos.y, _this.radius, 0, 2 * Math.PI, false);
            ctx.fillStyle = 'rgba(116,199,168,'+ _this.active+')';
            ctx.fill();
        };
    }

    // Util
    function getDistance(p1, p2) {
        return Math.pow(p1.x - p2.x, 2) + Math.pow(p1.y - p2.y, 2);
    }

});

     */
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
/*
window.onload = function() {
    //canvasDots();
};
*/

$j(document).promise().done(function( ) {

    console.log("promise");
    tp3_app.init = false;
    try {
        var evt = new Event('loaded');
        window.dispatchEvent(evt)
        $j(document).trigger('loaded');

    }
    catch (e) {
      /*  var evt = document.createEvent('Event');
        window.dispatchEvent( evt);
        evt.initEvent("loaded", true, true);
        */
        $j(document).trigger('loaded');

    }
})
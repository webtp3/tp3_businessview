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

var scroll = scroll || undefined , wresize  = wresize || undefined, mobile = mobile || false;
var headerPos = $j('header .container').offset().top;
var once = once || true;
var init = init || false;

var show = show || {}, go = go || {}, scoll_pos = scoll_pos || 0;
var scroll_pos = $j(document).scrollTop(),
    headerheight = $j('header.navbar-top').height(),
    headerwidth = $j('header.navbar').width(),
    logoheight = $j('.navbar-brand-image > img').height(),
    logowidth = $j('.navbar-brand-image > img').width(),
    toolbarheight = $j('.toolbar').first().height();
if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))){
    mobile = true;
    $j('body').addClass('ismobile');

}
else if(headerwidth < 992){
    $j('body').addClass('ismobile');
    mobile = true;
}
else{
    $j('body').removeClass('ismobile');
    mobile = false;

}

(scroll = function(event) {

    if(mobile != true || headerwidth > 600) {
        var scrollPos = $j(document).scrollTop();
        if(scroll_pos  == (headerPos) || scrollPos < (headerPos+2) ) {

            clearTimeout(go);
            //$j('header.navbar-top').height(100).css({position:"relative"});;
            //$j('header.navbar-top .container').removeClass('attached').css({'top' : '0px'});
            once = true;
            //$j('header.navbar-top .breadcrumb-section').hide();
            show = setTimeout(function() {
                $j('header.navbar-top').css({position:"fixed",top:"0px","z-index":"99"});
                $j('.toolbar .frame').css({padding:"16px 0"});
                $j('header.navbar-top').removeClass("flat");
              //  $j(' .navbar-main > li > a , .headerslogan').css({"height":(headerheight - toolbarheight)  +"px","line-height": (headerheight - toolbarheight)  +"px"});
                //$j('.headerslogan').css({"padding-left":"140px"});
                $j('.logo.cube').toggleClass('anim');
                $j('.logo.cube').addClass('show-front');

            }, 400);

            init = false;
        }

        if(scrollPos > headerPos && scroll_pos <= scrollPos) {
            clearTimeout(show);
            init = true;
            if(once === true) {
                once = false;
                go = setTimeout(function() {
                    //if(!$j('header.navbar-top').hasClass("flat"))$j(' a.navbar-brand-image, #logo').css({ "transform": "translate(100%,0%)"});

                    $j('header.navbar-top').addClass("flat");
                    $j('header.navbar-top > .cube').toggleClass('anim');
                    $j('.toolbar .frame').css({"padding":"8px 0"});
                  //  $j('header.navbar-top').height(headerheight / 2).width("100%").css({position:"fixed",top:"0px","z-index":"99"});
                  // $j(' .navbar-main > li > a ,.headerslogan').css({"height":(headerheight - toolbarheight) / 2  +"px","line-height": (headerheight - toolbarheight) / 2  +"px"});
                }, 400);
            }

            //$j('header.navbar-top').addClass('attached').css({'top' : (scrollPos-headerPos)+'px'});

        } else if(scrollPos < headerPos && scroll_pos >= scrollPos) {
            clearTimeout(show);
            init = true;
            if(once === true) {
                once = false;
                console.log("up")
                go = setTimeout(function() {
                   $j('.logo.cube').toggleClass('anim');
              //      $j('header.navbar-top').height(headerheight)
                    $j('.toolbar .frame').css({padding:"8px 0"});
                    $j('header.navbar-top').width("100%").css({position:"fixed",top:"0px","z-index":"99"});
                   // $j(' .navbar-main > li > a ,.headerslogan').css({"height":(headerheight - toolbarheight) / 2  +"px","line-height": (headerheight - toolbarheight) / 2  +"px"});
                }, 400);
            }

            //$j('header.navbar-top').addClass('attached').css({'top' : (scrollPos-headerPos)+'px'});

        } else if(init === true) {
            clearTimeout(go);
            once = true;
            //$j('header.navbar-top .breadcrumb-section').hide();
            show = setTimeout(function() {
                $j('header.navbar-top > .cube').addClass('anim');
                //$j('header.navbar-top ').toggleClass('anim');
                $j('.logo.cube').addClass('show-back');
            }, 400);

            init = false;
        }

        scroll_pos = $j(document).scrollTop();
    }
    else if ( $j(window).width() < 992 ){
        headerheight = 135 ;
        $j('.toolbar').insertAfter('header .navbar-header-main');//.navbar-collapse.collapse
        greeting.prependTo('#content')
       $j('.logo.cube').toggleClass('anim');
      //  $j('a.navbar-brand-image, #logo').width(headerwidth < 992 ? (logoheight/headerheight*0.7)*logowidth : (logoheight/headerheight)*logowidth * 0.7).height(headerheight * 0.7).css({ "transform": "translate(-200%,-50%)"});
        $j('header.navbar-top ').first().height(headerheight/2);
        if(headerwidth < 992)$j('.toolbar').insertAfter('.navbar-toggle').addClass('ismobile');


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

})();
$j(document).scroll(scroll);
$j(document).resize(scroll);
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
tp3_app.watchdog = function () {
    $j(document).on("loaded",function(){
        if(!tp3_app.init){
            tp3_app.initialize();


        }
        tp3_app.controls();
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
}


jQuery.fn.insertElementAtIndex=function(element,index){var lastIndex=this.children().length
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
    }
    catch (e) {
      /*  var evt = document.createEvent('Event');
        window.dispatchEvent( evt);
        evt.initEvent("loaded", true, true);
        */
        $j(window).trigger('loaded');

    }
})
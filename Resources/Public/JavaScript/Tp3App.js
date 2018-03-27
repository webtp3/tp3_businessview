$ = $j = jQuery.noConflict();
var tp3_app = tp3_app || {
    init:function(){
        tp3_app.scriptsload("//maps.googleapis.com/maps/api/js?key=AIzaSyAeFL1mw0cUjDZ5kSM7nTQiXgLTDZGJUwg&callback=tp3_app.initPano")
    }


},
map = map || {},
panorama = panorama || {};
tp3_app.initMap= function (){
        var berkeley = {lat: 37.869085, lng: -122.254775};
        var sv = new google.maps.StreetViewService();

        panorama = new google.maps.StreetViewPanorama(document.getElementById('pano'));

        // Set up the map.
        map = new google.maps.Map(document.getElementById('map'), {
            center: berkeley,
            zoom: 16,
            streetViewControl: false
        });

        // Set the initial Street View camera to the center of the map
        sv.getPanorama({location: berkeley, radius: 50}, tp3_app.processSVData);

        // Look for a nearby Street View panorama when the map is clicked.
        // getPanoramaByLocation will return the nearest pano when the
        // given radius is 50 meters or less.
        map.addListener('click', function(event) {
            sv.getPanorama({location: event.latLng, radius: 50}, tp3_app.processSVData);
        });
    }

tp3_app.initPano =    function (){
        var panorama = new google.maps.StreetViewPanorama(
            document.getElementById('pano'), {
                position: {lat: 37.869, lng: -122.255},
                pov: {
                    heading: 270,
                    pitch: 0
                },
                visible: true
            });

        panorama.addListener('pano_changed', function () {
            var panoCell = document.getElementById('pano-cell');
            panoCell.innerHTML = panorama.getPano();
        });

        panorama.addListener('links_changed', function () {
            var linksTable = document.getElementById('links_table');
            while (linksTable.hasChildNodes()) {
                linksTable.removeChild(linksTable.lastChild);
            }
            var links = panorama.getLinks();
            for (var i in links) {
                var row = document.createElement('tr');
                linksTable.appendChild(row);
                var labelCell = document.createElement('td');
                labelCell.innerHTML = '<b>Link: ' + i + '</b>';
                var valueCell = document.createElement('td');
                valueCell.innerHTML = links[i].description;
                linksTable.appendChild(labelCell);
                linksTable.appendChild(valueCell);
            }
        });

        panorama.addListener('position_changed', function () {
            var positionCell = document.getElementById('position-cell');
            positionCell.firstChild.nodeValue = panorama.getPosition() + '';
        });

        panorama.addListener('pov_changed', function () {
            var headingCell = document.getElementById('heading-cell');
            var pitchCell = document.getElementById('pitch-cell');
            headingCell.firstChild.nodeValue = panorama.getPov().heading + '';
            pitchCell.firstChild.nodeValue = panorama.getPov().pitch + '';
        });
    };
tp3_app.processSVData = function(data, status){
    if (status === 'OK') {
        var marker = new google.maps.Marker({
            position: data.location.latLng,
            map: map,
            title: data.location.description
        });

        panorama.setPano(data.location.pano);
        panorama.setPov({
            heading: 270,
            pitch: 0
        });
        panorama.setVisible(true);

        marker.addListener('click', function() {
            var markerPanoID = data.location.pano;
            // Set the Pano to use the passed panoID.
            panorama.setPano(markerPanoID);
            panorama.setPov({
                heading: 270,
                pitch: 0
            });
            panorama.setVisible(true);
        });
    } else {
        console.error('Street View data not found for this location.');
    }
};
tp3_app.scriptsload = function(data){
    var data_txt = data;

    $j(data_txt.responseText).each(function(){
        if(this.tagName == "script" || this.tagName == "SCRIPT"){


            if(this.src != undefined){

                //if(!this.src.toString().match(/fileadmin\/script/g))
                //if(!this.src.toString().match(/app/g))
               // if(this.src.toString().match(/fileadmin\/script/g).length < 1 && this.src.toString().match(/app.js/g).length < 1 && this.src.toString().match(/jquery/g).length < 1)loadScript(this.src)
                 $j.getScript(this.src, function(datax, textStatus, jqxhr) {
                    console.log(this, datax); //data returned
                   var sc = $j('<script/>', {
                      language: 'JavaScript',
                   text: datax != undefined && datax != '' ? datax : '',
                    }).appendTo('head');
                    console.log(textStatus); //success
                    console.log(jqxhr.status); //200
                    console.log('Load was performed.');
                  });
                  console.log(this)
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
    tp3_app.businessview_initialize = tp3_app.businessview_initialize  || function(businessviewJson){
    var panoEntry;
    var panoOptions;
    if(businessviewJson.details.panoEntry){
        panoEntry=businessviewJson.details.panoEntry;
    }else{
        var panoId='0yfJCnICQIUAAAQIt--IJw';
        if(businessviewJson.details.panoId){
            panoId=businessviewJson.details.panoId;
        }
        panoEntry={panoId:panoId,heading:0,pitch:1,zoom:1};
    }
    zoom=panoEntry.zoom;
    if(businessviewJson.details.panoOptions){
        panoOptions=businessviewJson.details.panoOptions;
    }else{
        panoOptions={disableDefaultUI:false,scrollwheel:false,panControl:true,zoomControl:true,scaleControl:true,addressControl:false};
    }
    initialize_Panorama(panoEntry,panoOptions);
    if(businessviewJson.details.modules&&businessviewJson.details.modules.sidebar){
        var sidebar=businessviewJson.details.modules.sidebar;showSidebar=sidebar.status;
        if(showSidebar){
            businessviewSidebarModulesSelector=' div#businessview-sidebar-canvas .content .wrapper';
            appendSidebarToBusinessview(sidebar.showGoogleMap,sidebar.logoUrl,sidebar.collapsed,sidebar.align,sidebar.backgroundColor,sidebar.textColor);$(businessviewCanvasSelector).on('click',
                'div#businessview-sidebar-canvas .toggle',function(){
                    if($(businessviewCanvasSelector+' div#businessview-sidebar-canvas').hasClass('closed')){
                        $(businessviewCanvasSelector+' div#businessview-sidebar-canvas').removeClass('closed').addClass('open');
                        $(businessviewCanvasSelector+' div#businessview-sidebar-canvas .content').show();
                    }else{
                        $(businessviewCanvasSelector+' div#businessview-sidebar-canvas').removeClass('open').addClass('closed');
                        $(businessviewCanvasSelector+' div#businessview-sidebar-canvas .content').hide();
                    }
                });
            $(window).scroll(function(){
                resizeSidebar();
            });
        }}
    if(businessviewJson.areas&&Object.size(businessviewJson.areas)>0){
        createAreaCanvas();
        if(businessviewJson.details.areaOrder&&businessviewJson.details.areaOrder.length>0){
            appendAreasToBusinessViewWithOrder(businessviewJson.areas,businessviewJson.details.areaOrder);
        }else{appendAreasToBusinessView(businessviewJson.areas);
        }
        $('ul#businessview-area-canvas').on('click','li',function(){
            window.clearInterval(panoJumpTimer);
            var pov={heading:parseFloat(
                    $(this).attr('data-entry-panorama-heading')
                ),pitch:parseFloat($(this).attr('data-entry-panorama-pitch'))
            };panorama.setPano($(this).attr('data-entry-panorama-id'));
            panorama.setPov(pov);
        });
    }
    if(businessviewJson.actions&&Object.size(businessviewJson.actions)>0){
        createActionCanvas();
        if(businessviewJson.details.actionOrder&&businessviewJson.details.actionOrder.length>0) {
            appendActionsToBusinessviewWithOrder(businessviewJson.actions,businessviewJson.details.actionOrder);
        }else{
            appendActionsToBusinessview(businessviewJson.actions);
        }
        $('ul#businessview-action-canvas').on('click','li',function(){
            if($(this).attr('data-action-target')=='fancybox'){
                $.fancybox.open({href:decodeURIComponent($(this).attr('data-object-url')),type:'iframe',padding:0,width:'80%',height:'80%',helpers:{overlay:{locked:false}}});}else{window.location.href=decodeURIComponent($(this).attr('data-object-url'));}});}
    $panoCanvas=$(businessviewCanvasSelector+' div#businessview-panorama-canvas');panoCanvasHeight=$panoCanvas.height();panoCanvasWidth=$panoCanvas.width();if(businessviewJson.infoPoints&&Object.size(businessviewJson.infoPoints)>0){createInfoPointCanvas();appendInfoPointsToBusinessview();$(businessviewCanvasSelector).on('mouseenter','div#businessview-infopoint-canvas div.with-tooltip:not(.without-url)',function(){$(this).find('div.tooltip').removeAttr('style').attr('style',getTooltipPopupPosition($(this))).addClass(' visible');});$(businessviewCanvasSelector).on('mouseleave','div#businessview-infopoint-canvas div.with-tooltip:not(.without-url)',function(){$(this).find('div.tooltip').removeAttr('style').removeClass("visible");});$(businessviewCanvasSelector).on('click','div#businessview-infopoint-canvas .infoPoint',function(){if($(this).hasClass('without-url')){if(!$(this).find('div.tooltip').hasClass('visible')){$(this).find('div.tooltip').removeAttr('style').attr('style',getTooltipPopupPosition($(this))).addClass(' visible');}else{$(this).find('div.tooltip').removeAttr('style').removeClass("visible");}}else{if($(this).attr('data-action-target')=='fancybox'){$.fancybox.open({href:decodeURIComponent($(this).attr('data-object-url')),type:'iframe',padding:0,width:'80%',height:'80%',helpers:{overlay:{locked:false}}});}else{window.location.href=decodeURIComponent($(this).attr('data-object-url'));}}});}
    if(businessviewJson.details.modules){if(businessviewJson.details.modules.googleAnalytics){var googleAnalytics=businessviewJson.details.modules.googleAnalytics;if(googleAnalytics.tracking){if(checkIfAnalyticsLoaded(googleAnalytics.code)){$('#businessview-actions-canvas').on('click','li',function(){ga('send','event','BusinessView Actions','click',$(this).text());});$('#businessview-areas-canvas').on('click','li',function(){ga('send','event','BusinessView Areas','click',$(this).text());});var viewportToggle=false;if(isInViewport(businessviewCanvasSelector)&&!viewportToggle){ga('send','event','BusinessView Canvas','scroll','in-viewport');viewportToggle=true;}
        $(window).scroll(function(){if(isInViewport(businessviewCanvasSelector)&&!viewportToggle){ga('send','event','BusinessView Canvas','scroll','in-viewport');viewportToggle=true;}
            if(!isInViewport(businessviewCanvasSelector)&&viewportToggle){viewportToggle=false;}});}}}
        if(businessviewJson.details.modules.intro){var intro=businessviewJson.details.modules.intro;if(intro.status&&(intro.headline!=""||intro.message!="")){appendIntroToBusinessview(intro.headline,intro.message,intro.backgroundColor,intro.textColor);$(businessviewCanvasSelector).on('click','div#businessview-intro-canvas i.fa-times',function(){removeBusinessviewCanvas('businessview-intro-canvas');});}}
        if(businessviewJson.details.modules.panoAnimation){var panoAnimation=businessviewJson.details.modules.panoAnimation;if(panoAnimation.jumps){var lastPano=panorama.getPano();panoJumpTimer=window.setInterval(function(){if(lastPano==panorama.getPano()){var links=panorama.getLinks();var nextPano;if(links.length>1){do{nextPano=links[getRandomInt(0,links.length-1)];}while(nextPano.pano==lastPano);lastPano=nextPano.pano;}else{nextPano=links[0];}
            panorama.setPano(nextPano.pano);}else{window.clearInterval(panoJumpTimer);}},5000);}
            if(panoAnimation.rotation){
                var lastPov=panorama.getPov();
                if($j.type(lastPov) == "object"){
                    panoRotationTimer=window.setInterval(function(){
                        var pov=panorama.getPov();

                        if($j.type(pov) == "object" && pov.heading==lastPov.heading){
                            pov.heading+=0.015;panorama.setPov(pov);lastPov=pov;
                        }else{
                            window.clearInterval(panoRotationTimer);window.clearInterval(panoJumpTimer);
                        }
                    },30);
                }

            }}
        if(businessviewJson.details.modules.contact){var contact=businessviewJson.details.modules.contact;if(contactBoxHasVisibleFields(contact.fields)){appendContactToBusinessview(contact.fields,contact.backgroundColor,contact.textColor,contact.align);}
            $(businessviewCanvasSelector).on('click','div#businessview-contact-canvas div#businessview-show-contact-details',function(){$(businessviewCanvasSelector+' div#businessview-contact-canvas div#businessview-show-contact-details').hide();$(businessviewCanvasSelector+' div#businessview-contact-canvas div#businessview-contact-details').show();});$(businessviewCanvasSelector).on('click','div#businessview-contact-canvas div#businessview-contact-details i.fa-times',function(){$(businessviewCanvasSelector+' div#businessview-contact-canvas div#businessview-contact-details').hide();$(businessviewCanvasSelector+' div#businessview-contact-canvas div#businessview-show-contact-details').show();});}
        if(businessviewJson.details.modules.gallery){var gallery=businessviewJson.details.modules.gallery;if(gallery.status&&gallery.googlePlacePhotos&&gallery.googlePlacePhotos.length>0){appendGalleryToBusinessview(gallery.googlePlacePhotos);$(businessviewCanvasSelector).on('click','ul#businessview-gallery-canvas a',function(){$(businessviewCanvasSelector+' ul#businessview-gallery-canvas a').fancybox({type:'image',padding:0,helpers:{overlay:{locked:false},thumbs:{width:50,height:50}},});});}}
        if(businessviewJson.details.modules.custom){var custom=businessviewJson.details.modules.custom;if(custom.status){appendCustomToBusinessview(custom.content,custom.align,custom.position,custom.backgroundColor,custom.textColor);}}
        if(businessviewJson.details.modules.openingHours){var openingHours=businessviewJson.details.modules.openingHours;if(openingHours.status){appendOpeningHoursToBusinessview(openingHours.formattedText);}}
        if(businessviewJson.details.modules.createdBy){var createdBy=businessviewJson.details.modules.createdBy;if(createdBy.status){appendCreatedByToBusinessview(createdBy.name);}}
        if(businessviewJson.details.modules.navigation){var navigation=businessviewJson.details.modules.navigation;if(navigation.status){appendNavigationToBusinessview(navigation.fields,navigation.pulse,navigation.backgroundColor,navigation.textColor);}}
        if(businessviewJson.details.modules.externalLinks){var externalLinks=businessviewJson.details.modules.externalLinks;if(externalLinks.status){appendExternalLinksToBusinessview(externalLinks);}}
        if(businessviewJson.details.modules.customFont){var customFont=businessviewJson.details.modules.customFont;if(customFont.fontName){setCustomFontToBusinessview(customFont.fontName);}}
        if(businessviewJson.details.modules.socialGallery){if(businessviewJson.details.modules.socialGallery.status&&socialGalleryHasActiveNetworks(businessviewJson.details.modules.socialGallery.networks)){var s='';s+='<div id="businessview-socialGallery-canvas" class="hidden"></div>';s+='<div id="businessview-socialGallery-trigger"></div>';$(businessviewCanvasSelector).append(s);resolveSocialGalleryNetworks(businessviewJson.details.modules.socialGallery.networks);$(businessviewCanvasSelector).on('click','div#businessview-socialGallery-canvas #close-socialGallery',function(){$(businessviewCanvasSelector+' div#businessview-socialGallery-canvas').addClass('hidden');$(businessviewCanvasSelector).removeClass('socialGallery-open');});$(businessviewCanvasSelector).on('click','div#businessview-socialGallery-trigger',function(){$(businessviewCanvasSelector+' div#businessview-socialGallery-canvas').removeClass('hidden');$(businessviewCanvasSelector).addClass('socialGallery-open');});$(businessviewCanvasSelector).on('click','div#businessview-socialGallery-canvas .network.facebookPage ul.albums li',function(){$.fancybox.helpers.overlay.open({parent:$('body')});$.fancybox.showLoading();var albumId=$(this).attr('data-album-id');if($('div#businessview-socialGallery-canvas .network.facebookPage ul.photos img[data-album-id="'+albumId+'"]').length==0){getFacebookPageAlbumPhotos(albumId);}else{showFacebookPageAlbumPhotos(albumId);}});}}
        if(businessviewJson.details.modules.fullscreenMode){var fullscreenMode=businessviewJson.details.modules.fullscreenMode;if(fullscreenMode.status){appendFullscreenModeToBusinessview();var fullscreenResizeTimer;var fullscreenResizeCounter=0;$(businessviewCanvasSelector).on('click','div#businessview-fullscreen-button',function(){var businessviewCanvas=document.getElementById('businessview-canvas');
            if(document.getElementById('tp3-iframe-embed')){businessviewCanvas=document.getElementById('tp3-iframe-embed');}
            if(!document.fullscreenElement&&!document.mozFullScreenElement&&!document.webkitFullscreenElement&&!document.msFullscreenElement){$(businessviewCanvasSelector).attr('data-normal-height',$(businessviewCanvasSelector).height());if(businessviewCanvas.requestFullscreen){businessviewCanvas.requestFullscreen();}else if(businessviewCanvas.msRequestFullscreen){businessviewCanvas.msRequestFullscreen();}else if(businessviewCanvas.mozRequestFullScreen){businessviewCanvas.mozRequestFullScreen();}else if(businessviewCanvas.webkitRequestFullscreen){businessviewCanvas.webkitRequestFullscreen();}}else{if(document.exitFullscreen){document.exitFullscreen();}else if(document.msExitFullscreen){document.msExitFullscreen();}else if(document.mozCancelFullScreen){document.mozCancelFullScreen();}else if(document.webkitExitFullscreen){document.webkitExitFullscreen();}}
            fullscreenResizeTimer=window.setInterval(function(){$(businessviewCanvasSelector).css('height',$(businessviewCanvasSelector).attr('data-normal-height')+'px');$(businessviewCanvasSelector+' #businessview-panorama-canvas').css('height',$(businessviewCanvasSelector).attr('data-normal-height')+'px');google.maps.event.trigger(panorama,'resize');fullscreenResizeCounter++;if(fullscreenResizeCounter==15){window.clearInterval(fullscreenResizeTimer);}},1000);});}}
        if(businessviewJson.details.modules.opentable){var opentable=businessviewJson.details.modules.opentable;if(opentable.status){appendOpenTableWidgetToBusinessView(opentable.restaurantId,opentable.align,opentable.position);$(businessviewCanvasSelector).on('click','div#businessview-opentable-canvas.fancybox .OTButton',function(){var url=decodeURIComponent($(this).attr('data-restaurant-url'));if(window.location.protocol=="https:"){window.location.href=url;}else{$.fancybox.open({href:url,type:'iframe',padding:0,width:'880px',height:'480px',helpers:{overlay:{locked:false}}});}});}}}
    resizeBusinessView(panoOptions);$(window).resize(function(){resizeBusinessView(panoOptions);});checkVisibleViewportObjects(panorama.getPano(),panorama.getPov());google.maps.event.addListener(panorama,'pov_changed',function(){checkVisibleViewportObjects(panorama.getPano(),panorama.getPov());updateInfoPoints();removeBusinessviewCanvas('businessview-intro-canvas');});google.maps.event.addListener(panorama,'position_changed',function(){initialize_CurrentPanoramaOverlays(panorama.getPano());checkVisibleViewportObjects(panorama.getPano(),panorama.getPov());centerBusinessViewCanvas('businessview-area-canvas');centerBusinessViewCanvas('businessview-intro-canvas');});google.maps.event.addListener(panorama,'zoom_changed',function(){zoom=panorama.getZoom();});panoResizeTimer=window.setInterval(function(){google.maps.event.trigger(panorama,'resize');panoResizeCounter++;if(panoResizeCounter==20){window.clearInterval(panoResizeTimer);}},1000);$('body').on('click','.businessview-deep-link',function(e){e.preventDefault();var businessviewId=$(this).attr('data-businessview-id');var panoId=$(this).attr('data-panorama-id');var heading=parseFloat($(this).attr('data-entry-heading'))||0;var pitch=parseFloat($(this).attr('data-entry-pitch'))||0;jumpToBusinessView(businessviewId,panoId,heading,pitch);});if(QueryString.businessviewId&&QueryString.panoramaId){var businessviewId=QueryString.businessviewId;var panoId=QueryString.panoramaId;var heading=parseFloat(QueryString.entryHeading)||0;var pitch=parseFloat(QueryString.entryPitch)||0;jumpToBusinessView(businessviewId,panoId,heading,pitch);}}
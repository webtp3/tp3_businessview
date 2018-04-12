define(['jquery','https://maps.google.com/maps/api/js?key='+window.apikey+'&libraries=places&sensor=true'], function ($) {

    var Tp3App = Tp3App || {
        init:function(){
            console.log("tp3app Init");
         //   Tp3App.scriptsload("//maps.googleapis.com/maps/api/js?key=zzz&")//callback=Tp3App.initPano
            if(($('.panolist tr.entry').length > 0 && $.trim($('.panolist tr.entry').first().find('.position').text()) != "")){
                try {
                    var arr = $.trim($('.panolist tr.entry').first().find('.position').text()).substring(1, $.trim($('.panolist tr.entry').first().find('.position').text()).length -1).split(',');
                    Tp3App.setBusinessAdress(arr[0],arr[1],$.trim($('.panolist tr.entry').first().find('.heading').text()),$.trim($('.panolist tr.entry').first().find('.pitch').text()),$.trim($('.panolist tr.entry').first().find('.zoom').text()));
                }
                catch (e){
                    console.log(e);
                }

            }
            Tp3App.setAnmationOptions();
            Tp3App.initPano();
            Tp3App.initMap();
            geocoder = new google.maps.Geocoder;
            infowindow = new google.maps.InfoWindow;
        /*    $('#editform').on("submit",function (e) {
                $('<div class="loaderbg"><div class="loader"></div></div>').appendTo($(e.currentTarget).parents("body").first()).css({position:"absolute", width:"100%", height:"100%", top :0, "z-index": "999", background: "rgba(0, 0, 0, 0.5)"});
                e.preventDefault(e);
                $('.loader').css({position:"absolute", left:"40%", top : window.pageYOffset, "z-index": "999"});
                var url = TYPO3.settings.ajaxUrls['tp3businessview_tp3businessview']; // the script where you handle the form input.

                $.ajax({
                    type: "GET",
                    url: url,
                    data:     $('#editform').serialize(), // serializes the form's elements.
                    success: function(data)
                    {
                        $('.loaderbg').remove();
                        console.log(data); // show response from the php script.
                        var result = $.parseJSON(data);


                    }
                });

                e.preventDefault(e); // avoid to execute the actual submit of the form.
                return false;
            })*/
            $('#submitNewform').on("click", function(e){
                e.preventDefault(e);
               $('#editform').attr("action", $('#editform').attr("action").replace("update","create"))
                $('#editform').find('input[name="tx_tp3businessview_web_tp3businessviewmodule[panoramas][uid]"]').val(null);
                $('#editform').submit();

            })
            $('#submitEditform').on("click", function(e){

            })
            $('#btn-controls').on("click", function(e){
                    $('.tp3businessview-controls.tp3-panel').toggle()
            })
            $('.panolist tr.entry').hover(function() {
                $(this).addClass('hover');
            }, function() {
                $(this).removeClass('hover');
            }).click(function(e){
                console.log(e);
                    $('#editform').find('input[name="tx_tp3businessview_web_tp3businessviewmodule[panoramas][uid]"]').val($(this).attr("id").split("_")[1]);
                    $('#editform').find('input[name="tx_tp3businessview_web_tp3businessviewmodule[panoramas][pid]"]').val($(this).attr("id").split("_")[2]);
                    $('#editform').find('input[name="tx_tp3businessview_web_tp3businessviewmodule[panoramas][pano_id]"]').val($.trim($(this).find('.pano_id').val()));
                    $('#editform').find('input[name="tx_tp3businessview_web_tp3businessviewmodule[panoramas][heading]"]').val($.trim($(this).find('.heading').text()));
                    $('#editform').find('input[name="tx_tp3businessview_web_tp3businessviewmodule[panoramas][pitch]"]').val($.trim($(this).find('.pitch').text()));
                    $('#editform').find('input[name="tx_tp3businessview_web_tp3businessviewmodule[panoramas][position]"]').val($.trim($(this).find('.position').text()));
                    $('#editform').find('input[name="tx_tp3businessview_web_tp3businessviewmodule[panoramas][title]"]').val($.trim($(this).find('.title').text()));



                    panorama.setPano($.trim($(this).find('.pano_id').val()));
                    panorama.setPov({
                        heading: Number($.trim($(this).find('.heading').text())),
                        pitch: Number($.trim($(this).find('.pitch').text()))
                    });
                    panorama.setVisible(true);
                    // $('#tp3businessview-floating-panel form').attr("name","updatepano")


            });
            $('.btn.btn-secondary.actions-view').on("click", function(e){
               if(window.businessviewJson != undefined) Tp3App.businessview_initialize(window.businessviewJson)
                else alert("no businessview")
            })
            $('.addresslist tr.entry').hover(function() {
                $(this).addClass('hover');
            }, function() {
                $(this).removeClass('hover');
            }).click(function(){
               if($.trim($(this).find('.place_id').text()) == "" || $.trim($(this).find('.geo_position').text()) == "" ) {
                   Tp3App.getPlace( $.trim($(this).find('.geo_address').text()));
               }

            });

            return Tp3App;
        },
        setBusinessAdress:function(latv ,lngv,headingv,pitchv,zoomv){
            Tp3App.BusinessAdress = {lat: Number(latv), lng: Number(lngv)};
            Tp3App.pov.heading =Number( headingv);
            Tp3App.pov.zoom = Number(zoomv);
            Tp3App.pov.pitch = Number(pitchv);

        },
        preview:false,
        BusinessAdress: {lat: 49.9553939, lng: 8.1767639},
        pov: {
            heading: 270,
            pitch: 0
        },
        AnmationOptions : {

            panoJumpTimer:200,
            panoRotationTimer:30,
            panoRotationFactor:0.015,
            panoJumpsRandom:true,

        },
        setAnmationOptions:function(){
            if($.type(window.AnmationOptions) == "object"){
                Tp3App.AnmationOption = window.AnmationOptions;
            }

        },

    },
    map = map || {},geocoder,infowindow,sv,e,
    panorama = panorama || {};
    Tp3App.getPlace= function (uid,address){
        var request= $.ajax({url:'//maps.google.com/maps/api/geocode/json?address='+address,type:'GET',headers:{"Access-Control-Allow-Headers":"*"}});
        request.done(function(result){
          var  data =  jQuery.parseJSON(result);
            console.log(data)

        }).fail(function() {
            console.log( "error" );
            e=true;

        }).always(function(result)  {
            if(e){
                //Fix for bad encoding by vhs viewhelper
                var errorContainer = $( '<div/>' );
                try{
                    errorContainer.html( result.responseText );
                    errorContainer.appendTo( $( 'body' ) ).hide();
                    data =  jQuery.parseJSON(errorContainer.text().replace("&quot;","'"));//

                }
                catch (e)
                {
                    console.log(e)
                }

            }
        })
    }
    Tp3App.initMap= function (){
        sv = new google.maps.StreetViewService();
        // reverse lookup if user has placeid
        geocoder = new google.maps.Geocoder;
        infowindow = new google.maps.InfoWindow;
        //panorama = new google.maps.StreetViewPanorama(document.getElementById('businessview-canvas'));

        // Set up the map.
        map = new google.maps.Map(document.getElementById('map'), {
            center: Tp3App.BusinessAdress,
            zoom: 16,
            streetViewControl: false
        });
        var streetviewOverlay = new google['maps']['StreetViewCoverageLayer']();
        streetviewOverlay.setMap(map);
        // Set the initial Street View camera to the center of the map
        sv.getPanorama({location: Tp3App.BusinessAdress, radius: 50}, Tp3App.processSVData);

        // Look for a nearby Street View panorama when the map is clicked.
        // getPanoramaByLocation will return the nearest pano when the
        // given radius is 50 meters or less.
        map.addListener('click', function(event) {
            sv.getPanorama({location: event.latLng, radius: 50}, Tp3App.processSVData);
        });

        // Init Placesapi with outocomplete to find placeid
        var input = document.getElementById('pac-input');

        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        var infowindow = new google.maps.InfoWindow();
        var marker = new google.maps.Marker({
            map: map
        });
        marker.addListener('click', function() {
            infowindow.open(map, marker);
        });

        autocomplete.addListener('place_changed', function() {
            infowindow.close();
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                return;
            }

            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }

            // Set the position of the marker using the place ID and location.
            marker.setPlace({
                placeId: place.place_id,
                location: place.geometry.location
            });
            marker.setVisible(true);

            document.getElementById('place-name').textContent = place.name;
            document.getElementById('place-id').textContent = place.place_id;
            document.getElementById('place-address').textContent =
                place.formatted_address;
            infowindow.setContent(document.getElementById('infowindow-content'));
            infowindow.open(map, marker);
        });



        /*   document.getElementById('reversesubmit').addEventListener('click', function() {
               Tp3App.geocodePlaceId(geocoder, map, infowindow);
           });*/
    },
    Tp3App.geocodePlaceId = function(geocoder, map, infowindow, placeId) {
      //  if(!placeId) placeId = document.getElementById('place-id').value;
        // reverse lookup if user has placeid

        geocoder.geocode({'placeId': placeId}, function(results, status) {
            if (status === 'OK') {
                if (results[0]) {
                    map.setZoom(11);
                    map.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location
                    });
                    infowindow.setContent(results[0].formatted_address);
                    infowindow.open(map, marker);
                } else {
                    window.alert('No results found');
                }
            } else {
                window.alert('Geocoder failed due to: ' + status);
            }
        });
    }
    Tp3App.initPano =    function (){
            panorama = new google.maps.StreetViewPanorama(
                document.getElementById('businessview-panorama-canvas'), {
                    position: Tp3App.BusinessAdress,
                    pov: {
                        heading: Tp3App.pov.heading,
                        pitch:  Tp3App.pov.pitch,
                        zoom: Tp3App.pov.zoom
                    },
                    visible: true
                });

            panorama.addListener('pano_changed', function () {
                var panoCell = document.getElementById('pano-cell');
                panoCell.value = panorama.getPano();
               // $('#tp3businessview-floating-panel form').attr("name","updatepano");
            });

            panorama.addListener('links_changed', function () {
                var linksTable = document.getElementById('links_table');
                while (linksTable.hasChildNodes()) {
                    linksTable.removeChild(linksTable.lastChild);
                }
                var linkst = window.businessviewJson.details.panoramas;
                for (var i in linkst) {
                    var row = document.createElement('tr');
                    linksTable.appendChild(row);
                    var labelCell = document.createElement('td');
                    labelCell.innerHTML = '<b>Link: ' + i + '</b>';
                    var valueCell = document.createElement('td');
                    valueCell.innerHTML = linkst[i].id;
                    linksTable.appendChild(labelCell);
                    linksTable.appendChild(valueCell);
                }
            });

            panorama.addListener('position_changed', function () {
                var positionCell = document.getElementById('position-cell');
                positionCell.value = panorama.getPosition() + '';
            });
            panorama.addListener('zoom_changed', function () {
                var zoomCell = document.getElementById('zoom-cell');
                zoomCell.value = panorama.getZoom() + '';
            });

            panorama.addListener('pov_changed', function () {
                var headingCell = document.getElementById('heading-cell');
                var pitchCell = document.getElementById('pitch-cell');
                var zoomCell = document.getElementById('zoom-cell');
                headingCell.value = panorama.getPov().heading + '';
                pitchCell.value = panorama.getPov().pitch + '';
                zoomCell.value = panorama.getPov().zoom + '';

            });
        }
    Tp3App.processSVData = function(data, status){
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
    Tp3App.scriptsload = function(data){
        var data_txt = data;
                return true;



                    //if(!this.src.toString().match(/fileadmin\/script/g))
                    //if(!this.src.toString().match(/app/g))
                   // if(this.src.toString().match(/fileadmin\/script/g).length < 1 && this.src.toString().match(/app.js/g).length < 1 && this.src.toString().match(/jquery/g).length < 1)loadScript(this.src)
                     return $.getScript(data_txt).done( function() {
                        console.log('Load was performed.');

                         try {
                             google.maps.event.addDomListener(window, "load", function () {
                                 Tp3App.initPano();
                             })
                         }
                         catch (e){
                             console.log(e);
                         }
                      });



    }
        Tp3App.businessview_initialize = Tp3App.businessview_initialize  || function(businessviewJson){
        var panoEntry;
        var panoOptions;
        var links;
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
            panoOptions={disableDefaultUI:false,scrollwheel:false,panControl:true,zoomControl:true,scaleControl:true,addressControl:false,fullScreen:false};
        }
        initialize_Panorama(panoEntry,panoOptions);
        if(businessviewJson.details.modules&&businessviewJson.details.modules.sidebar){
            var sidebar=businessviewJson.details.modules.sidebar;showSidebar=sidebar.status;
            if(showSidebar){
             var   businessviewSidebarModulesSelector=' div#businessview-sidebar-canvas .content .wrapper';
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
            if(businessviewJson.details.modules.panoAnimation){
            var panoAnimation=window.businessviewJson.details.modules.panoAnimation; var counter = 0;
                if(panoAnimation.jumps){
                    var lastPano=panorama.getPano();window.panoJumpTimer=window.setInterval(function(){
                        if(lastPano.panoId==panorama.getPano()){
                            links=window.businessviewJson.details.panoramas;var nextPano;
                            if(links.length>1 && Tp3App.AnmationOptions.panoJumpsRandom > 0){
                                do{nextPano=links[getRandomInt(0,links.length-1)];}
                                while(nextPano==lastPano);
                                lastPano=nextPano.pano;
                            } else if(links.length>1 && Tp3App.AnmationOptions.panoJumpsRandom < 1){
                                do{
                                    counter++;
                                    if(counter > links.length )counter = 0;
                                    nextPano=links[counter];
                                }
                                while(nextPano==lastPano);
                                lastPano=nextPano.pano;
                            }else{nextPano=links[0];}
                            panorama.setPano(nextPano.pano.panoId);
                            panorama.setPov({
                                heading: Number(nextPano.pano.heading),
                                pitch: Number(nextPano.pano.pitch)
                            });
                            panorama.setVisible(true);
                            if(panoAnimation.rotation){
                                var lastPov=panorama.getPov();
                                if($.type(lastPov) == "object"){
                                    panoRotationTimer=window.setInterval(function(){
                                        var pov=panorama.getPov();

                                        if($.type(pov) == "object" && pov.heading==lastPov.heading){
                                            pov.heading+=Tp3App.AnmationOptions.panoRotationFactor;panorama.setPov(pov);lastPov=pov;
                                        }else{
                                            //   document.clearInterval(panoRotationTimer);window.clearInterval(window.panoJumpTimer);
                                        }
                                    },Tp3App.AnmationOptions.panoRotationTimer);
                                }

                            }
                        }
                        //else{window.clearInterval(window.panoJumpTimer);}
                    },Tp3App.AnmationOptions.panoJumpTimer);}
                }
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
        resizeBusinessView(panoOptions);$(window).resize(function(){resizeBusinessView(panoOptions);});checkVisibleViewportObjects(panorama.getPano(),panorama.getPov());
        google.maps.event.addListener(panorama,'pov_changed',function(){
            checkVisibleViewportObjects(panorama.getPano(),panorama.getPov());
            updateInfoPoints();removeBusinessviewCanvas('businessview-intro-canvas');});
        google.maps.event.addListener(panorama,'position_changed',
            function(){
            initialize_CurrentPanoramaOverlays(
                panorama.getPano());
            checkVisibleViewportObjects(panorama.getPano(),panorama.getPov());
            centerBusinessViewCanvas('businessview-area-canvas');
            centerBusinessViewCanvas('businessview-intro-canvas');});
        google.maps.event.addListener(panorama,'zoom_changed',function(){zoom=panorama.getZoom();});
        panoResizeTimer=window.setInterval(function(){google.maps.event.trigger(panorama,'resize');
        panoResizeCounter++;if(panoResizeCounter==20){window.clearInterval(panoResizeTimer);}},1000);
        $('body').on('click','.businessview-deep-link',function(e){e.preventDefault();
        var businessviewId=$(this).attr('data-businessview-id');
        var panoId=$(this).attr('data-panorama-id');
        var heading=parseFloat($(this).attr('data-entry-heading'))||0;
        var pitch=parseFloat($(this).attr('data-entry-pitch'))||0;
        jumpToBusinessView(businessviewId,panoId,heading,pitch);});if(QueryString.businessviewId&&QueryString.panoramaId){
            var businessviewId=QueryString.businessviewId;var panoId=QueryString.panoramaId;var heading=parseFloat(QueryString.entryHeading)||0;var pitch=parseFloat(QueryString.entryPitch)||0;jumpToBusinessView(businessviewId,panoId,heading,pitch);}}

    var businessviewJson = businessviewJson || {},
        businessviewCanvasSelector = "#businessview-canvas";
    var panorama;var panoJumpTimer;var panoRotationTimer;var panoResizeTimer;var panoResizeCounter=0;var businessviewSidebarModulesSelector='';var showSidebar=false;var startCoords={},endCoords={};var zoom=1;var updateInfoPointsStartTimer;var updateInfoPointsCounter=0;var $panoCanvas=null;var panoCanvasHeight=0;var panoCanvasWidth=0;

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

        return query_string;

    } ();
    // Tp3App.init();
    return Tp3App.init();

    function initialize_CurrentPanoramaOverlays(panoId){var index=getPanoArrayPosition(panoId);setActionsInActive();setAreasInActive();setInfoPointsInActive();if(panoramaHasAreas(panoId)){setAreasActive(window.businessviewJson.details.panoramas[index].areas);}
        if(panoramaHasActions(panoId)){setActionsActive(window.businessviewJson.details.panoramas[index].actions);}
        if(panoramaHasInfoPoints(panoId)){appendInfoPointsToBusinessview();}}
    function initialize_Panorama(panoEntry,panoOptions){createPanoramaCanvas();var panoramaOptions={pano:panoEntry.panoId,pov:{heading:parseFloat(panoEntry.heading),pitch:parseFloat(panoEntry.pitch)},zoom:parseFloat(panoEntry.zoom),disableDefaultUI:panoOptions.disableDefaultUI,scrollwheel:panoOptions.scrollwheel,panControl:panoOptions.panControl,zoomControl:panoOptions.zoomControl,scaleControl:panoOptions.scaleControl,addressControl:panoOptions.addressControl,visible:true,mode:setPanoramaMode()};panorama=new google.maps.StreetViewPanorama(document.getElementById('businessview-panorama-canvas'),panoramaOptions);panorama.setVisible(true);currentPanoramaId=panoEntry.panoId;google.maps.event.trigger(panorama,'resize');$(businessviewCanvasSelector+' #businessview-panorama-canvas').bind("touchstart",function(e){endCoords=e.originalEvent.targetTouches[0];startCoords.pageX=e.originalEvent.targetTouches[0].pageX;startCoords.pageY=e.originalEvent.targetTouches[0].pageY;});$(businessviewCanvasSelector+' #businessview-panorama-canvas').bind("touchmove",function(e){endCoords=e.originalEvent.targetTouches[0];if(isInViewport(businessviewCanvasSelector+' div#businessview-panorama-canvas')){var y=$(window).scrollTop();var currentPitch=panorama.getPov().pitch;if(isCurrentPitchBetweenMinAndMax(currentPitch,0,30)||isCurrentPitchBetweenMinAndMax(currentPitch,150,180)){var delay=50;if(currentPitch<=10||currentPitch>=170){delay=15;}else if(currentPitch<=20||currentPitch>=160){delay=25;}else if(currentPitch<=35||currentPitch>=145){delay=35;}
        $(window).scrollTop(y-((endCoords.pageY-startCoords.pageY)/ delay));
    }}});}
    function addActionItemToBusinessview(itemObjectId,itemText,itemUrl,itemSize,itemIcon,itemBackgroundColor,itemTextColor,itemTarget,showPermanent){if(!itemTarget){itemTarget="fancybox";}
        if(itemIcon!='undefined'){itemIcon='<div class="fa '+ itemIcon+'"></div>';}else{itemIcon='';}
        if(validateEmail(decodeURIComponent(itemUrl))){itemUrl='mailto:'+ decodeURIComponent(itemUrl);itemTarget=true;}
        if(showPermanent){showPermanent='permanent';}else{showPermanent='';}
        $(businessviewCanvasSelector+' ul#businessview-action-canvas').append('<li data-object-id="'+ itemObjectId+'" data-object-url="'+ itemUrl+'" class="'+ itemSize+' '+ showPermanent+'" data-action-target="'+ itemTarget+'" '+ getColorStyle(itemBackgroundColor,itemTextColor)+'>'+ itemIcon+ itemText+'</li>');}
    function addAreaItemToBusinessview(itemObjectId,itemText,itemBackgroundColor,itemTextColor,entryPanoId,heading,pitch){$(businessviewCanvasSelector+' ul#businessview-area-canvas').append('<li data-object-id="'+ itemObjectId+'" data-entry-panorama-id="'+ entryPanoId+'" data-entry-panorama-heading="'+ heading+'" data-entry-panorama-pitch="'+ pitch+'" '+ getColorStyle(itemBackgroundColor,itemTextColor)+'>'+ itemText+'</li>');}
    function addInfoPointItemToBusinessview(itemObjectId,itemUrl,itemTooltip,itemSize,itemIcon,itemBackgroundColor,itemTextColor,itemTarget,pulse,itemViewport){if(!itemTarget){itemTarget="fancybox";}
        if(itemIcon!='undefined'){itemIcon='<div class="fa '+ itemIcon+'"></div>';}else{itemIcon='';}
        if(validateEmail(decodeURIComponent(itemUrl))){itemUrl='mailto:'+ decodeURIComponent(itemUrl);itemTarget=true;}
        if(pulse){pulse='pulse';}else{pulse='';}
        var tooltip=(itemTooltip&&itemTooltip!=""?true:false);var s='';s+='<div class="infoPoint '+ itemSize+' '+ pulse+' '+(tooltip?"with-tooltip":"")+' '+(itemUrl==""?"without-url":"")+'"'+ getColorStyle(itemBackgroundColor,itemTextColor);s+=' data-heading="'+itemViewport.heading+'"';s+=' data-pitch="'+itemViewport.pitch+'"';s+=' data-object-id="'+ itemObjectId+'"';s+=' data-object-url="'+ itemUrl+'"';s+=' data-action-target="'+ itemTarget+'"';s+='>';s+=itemIcon;if(tooltip){s+='<div class="tooltip">'+ itemTooltip+'</div>';}
        s+='</div>';$(businessviewCanvasSelector+' div#businessview-infopoint-canvas').append(s);}
    function addPhotoToGallery(renditions){$(businessviewCanvasSelector+' ul#businessview-gallery-canvas').append('<li><a href="'+ renditions.large.url+'" data-fancybox-group="businessview-gallery"><img src="'+ renditions.small.url+'" alt=""></a></li>');}
    function appendActionsToBusinessview(actions){for(var index in actions){addActionItemToBusinessview(index,actions[index].name,actions[index].url,actions[index].overlaysize,actions[index].icon,actions[index].backgroundColor,actions[index].textColor,actions[index].target,actions[index].showPermanent);}}
    function appendActionsToBusinessviewWithOrder(actions,order){for(var i=0;i<order.length;i++){var index=order[i];if(actions[index]){addActionItemToBusinessview(index,actions[index].name,actions[index].url,actions[index].overlaysize,actions[index].icon,actions[index].backgroundColor,actions[index].textColor,actions[index].target,actions[index].showPermanent);}}}
    function appendAreasToBusinessView(areas){for(var index in areas){addAreaItemToBusinessview(index,areas[index].name,areas[index].backgroundColor,areas[index].textColor,areas[index].entryPanoId,areas[index].entryHeading,areas[index].entryPitch);}
        centerBusinessViewCanvas('businessview-area-canvas');}
    function appendAreasToBusinessViewWithOrder(areas,order){for(var i=0;i<order.length;i++){var index=order[i];if(areas[index]){addAreaItemToBusinessview(index,areas[index].name,areas[index].backgroundColor,areas[index].textColor,areas[index].entryPanoId,areas[index].entryHeading,areas[index].entryPitch);}}
        centerBusinessViewCanvas('businessview-area-canvas');}
    function appendContactToBusinessview(fields,backgroundColor,textColor,align){var s='';s+='<div id="businessview-contact-canvas" class="'+ align+'" '+ getColorStyle(backgroundColor,textColor)+'>';s+='<div id="businessview-show-contact-details">Kontakt</div>';s+='<div id="businessview-contact-details">';s+='<div class="fa fa-times"></div>';if(fields.name.visible&&fields.name.value!=""){s+='<p class="name">'+ fields.name.value+'</p>';}
        if((fields.street.visible&&fields.street.value!="")||(fields.zip.visible&&fields.zip.value!="")||(fields.city.visible&&fields.city.value!="")){s+='<p class="address">';if(fields.street.visible&&fields.street.value!=""){s+=fields.street.value+'<br>';}
            if(fields.zip.visible&&fields.zip.value!=""){s+=fields.zip.value+' ';}
            if(fields.city.visible&&fields.city.value!=""){s+=fields.city.value;}
            s+='</p>';}
        if(fields.phone.visible&&fields.phone.value!=""){s+='<p class="phone"><div class="fa fa-phone"></div>'+ fields.phone.value+'</p>';}
        if(fields.email.visible&&fields.email.value!=""){s+='<p class="email"><div class="fa fa-envelope"></div><a href="mailto:'+ fields.email.value+'">'+ fields.email.value+'</a></p>';}
        if(fields.website.visible&&fields.website.value!=""){s+='<p class="website"><div class="fa fa-globe"></div><a href="'+ fields.website.value+'" target="_blank">'+ fields.website.value+'</a></p>';}
        s+='</div>';s+='</div>';$(businessviewCanvasSelector+ businessviewSidebarModulesSelector).insertElementAtIndex(s,getModulePositionIndex('contact'));if(align=='center'&&!showSidebar){centerBusinessViewCanvas('businessview-contact-canvas');}}
    function appendCreatedByToBusinessview(name){setTimeout(function(){$(businessviewCanvasSelector+' #businessview-panorama-canvas div.gm-style').append('<div id="businessview-created-by-canvas" class="gmnoprint" style="z-index: 1000001; position: absolute; right: 280px; bottom: 0px;"><div draggable="false" class="gm-style-cc" style="-webkit-user-select: none;"><div style="opacity: 0.7; width: 100%; height: 100%; position: absolute;"><div style="width: 1px;"></div><div style="background-color: rgb(245, 245, 245); width: auto; height: 100%; margin-left: 1px;"></div></div><div style="position: relative; padding-right: 6px; padding-left: 6px; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(68, 68, 68); white-space: nowrap; direction: ltr; text-align: right;"><span>Created by '+ name+'</span></div></div></div>');},1000);}
    function appendCustomToBusinessview(content,align,position,backgroundColor,textColor){$(businessviewCanvasSelector).append('<div id="businessview-custom-canvas" class="'+ align+' '+ position+'" '+ getColorStyle(backgroundColor,textColor)+'><div id="custom-wrapper">'+ content+'</div></div>');if(align=='center'){centerBusinessViewCanvas('businessview-custom-canvas');}
        if(position=='middle'){$(businessviewCanvasSelector+' #businessview-custom-canvas').css('margin-top','-'+($(businessviewCanvasSelector+' #businessview-custom-canvas').outerHeight()/2) + 'px');
        }}
    function appendExternalLinksToBusinessview(externalLinks){var string='';var color='';if(externalLinks.backgroundColor&&externalLinks.textColor){color=getColorStyle(externalLinks.backgroundColor,externalLinks.textColor);}
        for(var i=0;i<externalLinks.links.length;i++){string+=getExternalLinksBusinessViewString(externalLinks.links[i],color);}
        $(businessviewCanvasSelector).append('<ul id="businessview-externalLinks-canvas" class="'+(externalLinks.size?externalLinks.size:'')+'">'+ string+'</ul>');}
    function appendFacebookPageAlbumsToBusinessView(albums,disabledAlbums){if(albums.length>0){var s='';for(var i=0;i<albums.length;i++){if(albums[i].count&&!isAlbumIdDisabled(albums[i].id,disabledAlbums)){s+='<li data-album-id="'+ albums[i].id+'">';s+='<div class="image-wrapper" data-cover-photo-id="'+ albums[i].cover_photo+'">';s+='</div>';s+='<p class="name">'+ albums[i].name+'</p>';s+='</li>';getFacebookPageAlbumsCoverPhotoUrl(albums[i].id,albums[i].cover_photo);}}
        $(businessviewCanvasSelector+' div#businessview-socialGallery-canvas .albums').html(s);}}
    function appendFacebookPageAlbumPhotosToBusinessView(albumId,photos){var s='';for(var i=0;i<photos.length;i++){s+='<li>';s+='<a href="'+photos[i].source+'" data-fancybox-group="businessview-socialGallery-'+albumId+'">';s+='<img src="'+photos[i].source+'" data-album-id="'+albumId+'">';s+='</a>';s+='<li>';}
        $(businessviewCanvasSelector+' div#businessview-socialGallery-canvas .network.facebookPage ul.photos').append(s);showFacebookPageAlbumPhotos(albumId);}
    function appendFullscreenModeToBusinessview(){$(businessviewCanvasSelector).append('<div id="businessview-fullscreen-button"></div>');}
    function appendGalleryToBusinessview(photos){$(businessviewCanvasSelector).append('<ul id="businessview-gallery-canvas"></ul>');for(var i=0;i<photos.length;i++){addPhotoToGallery(photos[i].renditions);}
        $('ul#businessview-gallery-canvas img').load(function(){centerBusinessViewCanvas('businessview-gallery-canvas');});}
    function appendInfoPointsToBusinessview(){setInfoPointsInActive();var panoId=panorama.getPano();var index=getPanoArrayPosition(panoId);if(window.businessviewJson.details.panoramas&&window.businessviewJson.details.panoramas[index]&&window.businessviewJson.details.panoramas[index].infoPoints){var infoPoints=window.businessviewJson.details.panoramas[index].infoPoints;var objects=window.businessviewJson.infoPoints;for(var i=0;i<infoPoints.length;i++){var objectId=infoPoints[i].id;var viewport=infoPoints[i].viewport;if(objects[objectId]){addInfoPointItemToBusinessview(objectId,objects[objectId].url,objects[objectId].tooltip,objects[objectId].size,objects[objectId].icon,objects[objectId].backgroundColor,objects[objectId].textColor,objects[objectId].target,objects[objectId].pulse,viewport);}}
        updateInfoPoints();}}
    function appendIntroToBusinessview(headline,message,backgroundColor,textColor){var content='';if(headline!=""){content+='<h1>'+ headline+'</h1>';}
        if(message!=""){content+='<p>'+ message+'</p>';}
        $(businessviewCanvasSelector).append('<div id="businessview-intro-canvas" '+ getColorStyle(backgroundColor,textColor)+'><div class="fa fa-times"></div>'+ content+'</div>');centerBusinessViewCanvas('businessview-intro-canvas');}
    function appendNavigationToBusinessview(fields,pulse,backgroundColor,textColor){if(fields.length>0){var string='';string+='<div id="businessview-navigation-canvas" class="dl-menuwrapper">';string+='<button class="dl-trigger'+(pulse?' pulse':'')+'" '+ getColorStyle(backgroundColor,textColor)+'><div class="fa fa-bars"></div></button>';string+='<ol class="dl-menu" '+ getColorStyle(backgroundColor,textColor)+'>';string+=getNavigationBusinessViewStructureString(fields);string+='</ol>';string+='</div>';$(businessviewCanvasSelector+ businessviewSidebarModulesSelector).insertElementAtIndex(string,getModulePositionIndex('navigation'));if(businessviewSidebarModulesSelector!=''){$('#businessview-navigation-canvas ol.dl-menu').addClass('dl-menuopen');}
        $('#businessview-navigation-canvas').dlmenu({animationClasses:{classin:'dl-animate-in-3',classout:'dl-animate-out-3'},onLinkClick:function(e){var pov={heading:parseFloat($(e).attr('data-entry-panorama-heading')),pitch:parseFloat($(e).attr('data-entry-panorama-pitch'))};panorama.setPano($(e).attr('data-entry-panorama-id'));panorama.setPov(pov);event.preventDefault();}});}}
    function appendOpeningHoursToBusinessview(string){if(window.businessviewJson.details.modules.contact&&contactBoxHasVisibleFields(window.businessviewJson.details.modules.contact.fields)){$('div#businessview-contact-canvas div#businessview-contact-details').append('<p id="opening-hours"></p>');}else{$(businessviewCanvasSelector).append('<div id="businessview-opening-hours-canvas"><p id="opening-hours"></p></div>');}
        $(businessviewCanvasSelector+' p#opening-hours').html('<strong>Öffnungszeiten</strong><br>'+ string);}
    function appendOpenTableWidgetToBusinessView(opentableRestaurantId,align,position){var lightbox=true;var url='http://www.opentable.de/single.aspx?rid='+opentableRestaurantId+'&rtype=ism&restref='+opentableRestaurantId;if(window.location.protocol=="https:"){lightbox=false;}
        var s='';s+='<div id="businessview-opentable-canvas" class="'+align+' '+position+' '+((lightbox)?'fancybox':'')+'">';s+='<'+((lightbox)?'div data-restaurant-url="'+url+'" ':'a href="'+url+'" target="_blank" ')+' class="OTButton">';s+='<div class="OTReserveNow">';s+='<div id="OTReserveNow" class="OTReserveNow">';s+='<span class="OTReserveNowInner">Tisch buchen</span>';s+='</div>';s+='</div>';s+='<div id="OTPoweredBy" class="OTPoweredBy">Powered By OpenTable</div>';s+='</'+((lightbox)?'div':'a')+'>';s+='</div>';$(businessviewCanvasSelector).append(s);}
    function appendSidebarToBusinessview(showGoogleMap,logoUrl,collapsed,align,backgroundColor,textColor){var panoramaControlsPosition={panControlOptions:{position:google.maps.ControlPosition.TOP_LEFT},zoomControlOptions:{position:google.maps.ControlPosition.TOP_LEFT},streetViewControlOptions:{position:google.maps.ControlPosition.TOP_LEFT}};if(align=='left'){panoramaControlsPosition={panControlOptions:{position:google.maps.ControlPosition.TOP_RIGHT},zoomControlOptions:{position:google.maps.ControlPosition.TOP_RIGHT},streetViewControlOptions:{position:google.maps.ControlPosition.TOP_RIGHT}};}
        panorama.setOptions(panoramaControlsPosition);var s='';s+='<div id="businessview-sidebar-canvas" class="'+(!collapsed?'open':'closed')+'" '+ getColorStyle(backgroundColor,textColor)+'>';s+='<div class="toggle"></div>';s+='<div class="content">';if(logoUrl){s+='<div class="logo">';s+='<img src="'+logoUrl+'">';s+='</div>';}
        s+='<div class="wrapper"></div>';s+='</div>';s+='</div>';$(businessviewCanvasSelector).addClass('sidebar-'+align);$(businessviewCanvasSelector).append(s);resizeSidebar(align);}
    function resizeSidebar(align){$(businessviewCanvasSelector+' div#businessview-sidebar-canvas').css('height',getSidebarHeight(align)+'px');$(businessviewCanvasSelector+' div#businessview-sidebar-canvas .toggle').css('line-height',getSidebarToggleHeight()+'px');}
    function getSidebarToggleHeight(){var posTop=$(businessviewCanvasSelector).offset().top;var posBottom=posTop+ $(businessviewCanvasSelector).height();var viewportTop=$(window).scrollTop();var height=$(businessviewCanvasSelector+' div#businessview-sidebar-canvas').outerHeight();var margin=60;var offset=60;if(viewportTop<=posTop&&posBottom<=$(window).height()){return height;}
        if(posTop!=0&&posBottom!=$('html').height()){if(viewportTop<=posTop- 60){return margin;}
            if(viewportTop>=posBottom-($(businessviewCanvasSelector).height()/2) ) {
                return(height*2)- margin;}}
        return height;}
    function appendSocialGalleryFacebookPageWrapper(pageId){
        var s='';s+='<div id="close-socialGallery"><div class="fa fa-times"></div></div>';s+='<div class="wrapper">';s+='<div class="network facebookPage">';s+='<p class="network-name"><a href="https://www.facebook.com/'+pageId+'" target="_blank"><div class="fa fa-facebook"></div>Facebook Page Fotos</a></p>';s+='<hr>';s+='<ul class="albums"></ul>';s+='<ul class="photos"></ul>';s+='</div>';s+='</div>';$(businessviewCanvasSelector+' div#businessview-socialGallery-canvas').append(s);
    }
    function appendSocialGalleryTriggerPreviewImages(imageUrl){if($(businessviewCanvasSelector+' div#businessview-socialGallery-trigger div').length<3){$(businessviewCanvasSelector+' div#businessview-socialGallery-trigger').append('<div style="background-image: url('+imageUrl+');"></div>');}}
    function centerBusinessViewCanvas(canvasId){var width=($(businessviewCanvasSelector+' #'+ canvasId).outerWidth()/2);
        if($('body').hasClass('facebook-tab')&&width>265){width=265;}
        $(businessviewCanvasSelector+' #'+ canvasId).css('margin-left','-'+ width+'px');}
    function checkIfAnalyticsLoaded(trackingCode){if(window.ga){return true;}else if(window.urchinTracker){return false;}else{if(window.location.protocol=="http:"||window.location.protocol=="https:"){(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');ga('create',trackingCode,window.location.host);ga('send','pageview');return true;}else{return false;}}}
    function checkVisibleViewportObjects(panoId,pov){var index=getPanoArrayPosition(panoId);setAreasInActive();if(panoramaHasAreas(panoId)){setAreasActive(getVisibleObjects(window.businessviewJson.details.panoramas[index].areas,pov));}
        setActionsInActive();if(panoramaHasActions(panoId)){setActionsActive(getVisibleObjects(window.businessviewJson.details.panoramas[index].actions,pov));}}
    function contactBoxHasVisibleFields(fields){for(var index in fields){if(fields[index].visible){return true;}}
        return false;}
    function convertDegreesToRadians(angle){angle=angle*0.017453292519943295;while(angle<0.0){angle+=6.28318530718;}
        while(angle>6.28318530718){angle-=6.28318530718;}
        return angle;}
    function convertRadiansToDegrees(angle){angle=angle/0.017453292519943295;while(angle<- 180.0){angle+=360.0;}
        while(angle>180.0){angle-=360.0;}
        return angle;}
    function convertHeadingInDegree(heading){var degree;heading=heading%360
        if(heading>=0){degree=0+ heading;}else{degree=360+ heading;}
        return degree;}
    function convertPitchInDegree(pitch){return(pitch%180)+ 90;}
    function createActionCanvas(){$(businessviewCanvasSelector+ businessviewSidebarModulesSelector).insertElementAtIndex('<ul id="businessview-action-canvas"></ul>',getModulePositionIndex('actions'));}
    function createAreaCanvas(){$(businessviewCanvasSelector).append('<ul id="businessview-area-canvas"></ul>');}
    function createInfoPointCanvas(){$(businessviewCanvasSelector).append('<div id="businessview-infopoint-canvas"></div>');}
    function createPanoramaCanvas(){
//$(businessviewCanvasSelector).append('<div id="businessview-panorama-canvas" style="min-height:320px;"></div>');
    }
    function getColorStyle(backgroundColor,textColor){return' style="background-color: '+ backgroundColor+'; color: '+ textColor+';" ';}
    function getExternalLinksBusinessViewString(link,color){var string='';if(link.visible){var target='';if(link.target){target='target="_blank"';}
        string+='<li class="externalLink" '+ color+'><a href="'+ link.url+'" '+ target+'><div class="fa '+ link.icon+'"></div></li>';}
        return string;}
    function getFacebookPageAlbumsCoverPhotoUrl(albumId,coverId){
        var imageUrl='//web.tp3.de/fileadmin/tp3/ico.png';var request=$.ajax({url:'https://graph.facebook.com/'+coverId,type:'GET',headers:{"Access-Control-Allow-Headers":"*"}});request.done(function(jsonResponse){if(jsonResponse){imageUrl=jsonResponse.images[0].source;}
            $(businessviewCanvasSelector+' div#businessview-socialGallery-canvas li[data-album-id="'+ albumId+'"] .image-wrapper[data-cover-photo-id="'+ coverId+'"]').css('background-image','url('+imageUrl+')');appendSocialGalleryTriggerPreviewImages(imageUrl);});request.fail(function(jqXHR,textStatus){$(businessviewCanvasSelector+' div#businessview-socialGallery-canvas li[data-album-id="'+ albumId+'"] .image-wrapper[data-cover-photo-id="'+ coverId+'"]').css('background-image','url('+imageUrl+')');});
    }
    function getFacebookPageAlbumPhotos(albumId){var request=$.ajax({url:'https://graph.facebook.com/'+albumId+'/photos',type:'GET',headers:{"Access-Control-Allow-Headers":"*"}});request.done(function(jsonResponse){if(jsonResponse){appendFacebookPageAlbumPhotosToBusinessView(albumId,jsonResponse.data);}});request.fail(function(jqXHR,textStatus){console.log("There was an error connection to Facebook. Please try again later!");});}
    function getFacebookPageAlbums(pageId,disabledIds){
        /*
        $.when(docReady, facebookReady).then(function() {
            var allPhotos = [];
                    var accessToken = '';
                    pageId = pageId || "tp3service";
                    disabledIds = disabledIds || [];
                    login(function(loginResponse) {
                            accessToken = loginResponse.authResponse.accessToken || '';
                            //var request=$.ajax({url:'https://graph.facebook.com/'+pageId+'/albums',type:'GET',headers:{"Access-Control-Allow-Headers":"*"}});request.done(function(jsonResponse){if(jsonResponse){appendFacebookPageAlbumsToBusinessView(jsonResponse.data,disabledIds);}});request.fail(function(jqXHR,textStatus){console.log(textStatus);});
        var request=$.ajax({url:'https://graph.facebook.com/'+pageId+'/albums?access_token=' + accessToken,type:'GET',headers:{"Access-Control-Allow-Headers":"*"}});request.done(function(jsonResponse){if(jsonResponse){appendFacebookPageAlbumsToBusinessView(jsonResponse.data,disabledIds);}});request.fail(function(jqXHR,textStatus){console.log(textStatus);});
                            getAlbums(function(albumResponse) {
                                    var i, album, deferreds = {}, listOfDeferreds = [];
                                    for (i = 0; i < albumResponse.data.length; i++) {
                                        album = albumResponse.data[i];
                                        deferreds[album.id] = $.Deferred();
                                        listOfDeferreds.push( deferreds[album.id] );
                                        getPhotosForAlbumId( album.id, function( albumId, albumPhotosResponse ) {
                                                var i, facebookPhoto;
                                                for (i = 0; i < albumPhotosResponse.data.length; i++) {
                                                    facebookPhoto = albumPhotosResponse.data[i];
                                                    allPhotos.push({
                                                        'id'	:	facebookPhoto.id,
                                                        'added'	:	facebookPhoto.created_time,
                                                        'url'	:	makeFacebookPhotoURL( facebookPhoto.id, accessToken )
                                                    });
                                                }
                                                deferreds[albumId].resolve();
                                            });
                                    }
                                    $.when.apply($, listOfDeferreds ).then( function() {
                                        if (callback) {
                                            callback( allPhotos );
                                        }
                                    }, function( error ) {
                                        if (callback) {
                                            callback( allPhotos, error );
                                        }
                                    });
                                });
                        });
                });
        */

//var request=$.ajax({url:'https://graph.facebook.com/'+pageId+'/albums',type:'GET',headers:{"Access-Control-Allow-Headers":"*"}});request.done(function(jsonResponse){if(jsonResponse){appendFacebookPageAlbumsToBusinessView(jsonResponse.data,disabledIds);}});request.fail(function(jqXHR,textStatus){console.log(textStatus);});
    }
    function getFieldOfView(zoom){return 0.91667*Math.pow(zoom,3)- 1.35714*Math.pow(zoom,2)- 37.4881*zoom+ 127.186;}
    function getModulePositionIndex(moduleName){var position=0;if(showSidebar){if(moduleName=='actions'){position=0;}else if(moduleName=='contact'){if($(businessviewSidebarModulesSelector+' #businessview-action-canvas').exists()){position=1;}}else if(moduleName=='navigation'){position=3;}else{position=$(businessviewSidebarModulesSelector).children().length;}}
        return position;}
    function getNavigationBusinessViewStructureString(fields){var string='';for(var i=0;i<fields.length;i++){if(fields[i].subFields&&fields[i].subFields.length>0){string+='<li>';string+='<span>'+fields[i].name+'</span>';string+='<ol class="dl-submenu">';string+='<li class="dl-back"><span>'+fields[i].name+'</span></li>';string+=getNavigationBusinessViewStructureString(fields[i].subFields);string+='</ol>';string+='</li>';}else{string+='<li data-entry-panorama-id="'+ fields[i].pov.panoId+'" data-entry-panorama-heading="'+ fields[i].pov.entryHeading+'" data-entry-panorama-pitch="'+ fields[i].pov.entryPitch+'"><span>'+ fields[i].name+'</span></li>';}}
        return string;}
    function getPanoArrayPosition(panoId){
        if(window.businessviewJson.details.panoramas!=undefined){
            for(var i=0;i<window.businessviewJson.details.panoramas.length;i++)
            {if(window.businessviewJson.details.panoramas[i].id==panoId){return i;}}}
            else{window.businessviewJson.details.panoramas=window.businessviewJson.details.panoramas||
            [];
        }
        var array=new Object;array.actions=[];array.areas=[];array.infoPoints=[];array.id=panoId;window.businessviewJson.details.panoramas.push(array);return getPanoArrayPosition(panoId);}
    function getRandomInt(min,max){return Math.floor(Math.random()*(max- min+ 1))+ min;}
    function getSidebarHeight(align){if(!align){if($(businessviewCanvasSelector).hasClass('sidebar-left')){align='left';}}
        var height=$(businessviewCanvasSelector).outerHeight(true);if(align=='left'){height-=50;}else{height-=34;}
        return height;}
    function getTooltipPopupPosition(infoPoint){positionString='';var position=infoPoint.position();var height=infoPoint.find('div.tooltip').height();var width=infoPoint.find('div.tooltip').width();var canvasHeight=$(businessviewCanvasSelector).height();var canvasWidth=$(businessviewCanvasSelector).width();var x1=position.left;var x2=position.left+ width;var y1=position.top;var y2=position.top+ height;positionString+=(x2<(canvasWidth- 50)?' left: ':' right: ')+(infoPoint.width()+ 5)+'px;';positionString+=(y2<(canvasHeight- 50)?' top: ':' bottom: ')+(infoPoint.height()+ 5)+'px;';return positionString;}
    function getVisibleObjects(objects,pov){var visibleObjects=[];for(var i=0;i<objects.length;i++){if((isCurrentHeadingBetweenMinAndMax(pov.heading,objects[i].visibleHeading.from,objects[i].visibleHeading.to))&&(isCurrentPitchBetweenMinAndMax(pov.pitch,objects[i].visiblePitch.from,objects[i].visiblePitch.to))){visibleObjects.push(objects[i].id);}}
        return visibleObjects;}
    function isAlbumIdDisabled(albumId,disabledAlbums){return disabledAlbums.indexOf(albumId)>-1;}
    function isCurrentHeadingBetweenMinAndMax(x,min,max){x=convertHeadingInDegree(x);if(x>0){if(min<0&&max<0){min=360+ min;max=360+ max;}}
        return x>=min&&x<=max;}
    function isCurrentPitchBetweenMinAndMax(x,min,max){x=convertPitchInDegree(x);if(x>0){if(min<0&&max<0){min=180+ min;max=180+ max;}}
        return x>=min&&x<=max;}
    function isInViewport(elem){var elemPosTop=$(elem).position().top;var elemPosBottom=elemPosTop+ $(elem).height();var viewportTop=$(window).scrollTop();var viewportBottom=viewportTop+ window.innerHeight;var offset=50;return((viewportBottom- offset)>=elemPosTop)&&((viewportTop- offset)<=elemPosBottom);}
    function jumpToBusinessView(businessviewId,panoId,heading,pitch){if(businessviewId!=""&&panoId!=""){var options={pano:panoId,pov:{heading:heading,pitch:pitch}};panorama.setOptions(options);$(businessviewCanvasSelector).scrollToViewPort(1000);}}
    function panElement(element,pano_heading,pano_pitch,width,height,zoom){var elementHeading=convertDegreesToRadians(parseFloat(element.attr("data-heading")));var elementPitch=convertDegreesToRadians(parseFloat(element.attr("data-pitch")));var fov=getFieldOfView(zoom)*Math.PI/180.0;var h0=pano_heading;var p0=pano_pitch;var h=elementHeading;var p=elementPitch;var cos_p=Math.cos(p);var sin_p=Math.sin(p);var cos_h=Math.cos(h);var sin_h=Math.sin(h);var f=(width/2)/ Math.tan(fov / 2);
        var x=f*cos_p*sin_h;var z=f*sin_p;var y=f*cos_p*cos_h;var cos_p0=Math.cos(p0);var sin_p0=Math.sin(p0);var cos_h0=Math.cos(h0);var sin_h0=Math.sin(h0);var x0=f*cos_p0*sin_h0;var z0=f*sin_p0;var y0=f*cos_p0*cos_h0;var nDotD=x0*x+ y0*y+ z0*z;var nDotC=x0*x0+ y0*y0+ z0*z0;if(Math.abs(nDotD)<1e-6){element.hide();}else{var t=nDotC/nDotD;if(t<0.0){element.hide();}else{var tx=t*x;var ty=t*y;var tz=t*z;var vx=- sin_p0*sin_h0;var vy=- sin_p0*cos_h0;var vz=cos_p0;var ux=cos_p0*cos_h0;var uy=- cos_p0*sin_h0;var uz=0;var ul=Math.sqrt(ux*ux+ uy*uy+ uz*uz);ux/=ul;uy/=ul;uz/=ul;var du=tx*ux+ ty*uy+ tz*uz;var dv=tx*vx+ ty*vy+ tz*vz;var u0=width/2;var v0=height/2;var u=u0+ du;var v=v0- dv;element.css({"left":u,"bottom":height- v}).show();}}}
    function panoramaHasActions(panoId){var index=getPanoArrayPosition(panoId);if(index!=undefined&&window.businessviewJson.details.panoramas[index].actions.length>0){return true;}else{return false;}}
    function panoramaHasAreas(panoId){var index=getPanoArrayPosition(panoId);if(index!=undefined&&window.businessviewJson.details.panoramas[index].areas.length>0){return true;}else{return false;}}
    function panoramaHasInfoPoints(panoId){var index=getPanoArrayPosition(panoId);if(index!=undefined&&window.businessviewJson.details.panoramas[index].infoPoints.length>0){return true;}else{return false;}}
    function removeBusinessviewCanvas(canvasId){$(businessviewCanvasSelector+' #'+ canvasId).remove();}
    function resizeBusinessView(panoOptions){var businessviewHeight=$(businessviewCanvasSelector).outerHeight(true);$(businessviewCanvasSelector+' #businessview-panorama-canvas').css('height',businessviewHeight+'px');if(showSidebar){resizeSidebar();}
        centerBusinessViewCanvas('businessview-area-canvas');centerBusinessViewCanvas('businessview-gallery-canvas');centerBusinessViewCanvas('businessview-intro-canvas');if($(businessviewCanvasSelector).width()<768){panorama.setOptions({panControl:false,zoomControl:false,scaleControl:false,addressControl:false});}else{panorama.setOptions({panControl:panoOptions.panControl,zoomControl:panoOptions.zoomControl,scaleControl:panoOptions.scaleControl,addressControl:panoOptions.addressControl});}
        panoCanvasHeight=$panoCanvas.height();panoCanvasWidth=$panoCanvas.width();updateInfoPoints();}
    function resolveSocialGalleryNetworks(networks){for(var i=0;i<networks.length;i++){if(networks[i].status){if(networks[i].type=="facebookPage"){appendSocialGalleryFacebookPageWrapper(networks[i].id);getFacebookPageAlbums(networks[i].id,networks[i].disabled);}}}}
    function setActionsActive(actions){for(var i=0;i<actions.length;i++){$('ul#businessview-action-canvas li[data-object-id="'+ actions[i]+'"]').addClass('active');}}
    function setActionsInActive(){$('ul#businessview-action-canvas li').removeClass('active');}
    function setAreasActive(areas){for(var i=0;i<areas.length;i++){$('ul#businessview-area-canvas li[data-object-id="'+ areas[i]+'"]').addClass('active');}}
    function setAreasInActive(){$('ul#businessview-area-canvas li').removeClass('active');}
    function setCustomFontToBusinessview(fontName){$(businessviewCanvasSelector).css('font-family',fontName+", 'Helvetica Neue', Helvetica, Arial, sans-serif");}
    function setInfoPointsInActive(){$(businessviewCanvasSelector+' div#businessview-infopoint-canvas').html('');}
    function setPanoramaMode(){var mode;var browser=navigator.sayswho;if(webgl_detect()){mode='webgl';}else if(browser[0]=='Safari'||browser[0]=='Firefox'||browser[0]=='Chrome'){mode='html5';}
        return mode;}
    function showFacebookPageAlbumPhotos(albumId){var data=[];var photos=$(businessviewCanvasSelector+' div#businessview-socialGallery-canvas .network.facebookPage ul.photos a[data-fancybox-group="businessview-socialGallery-'+albumId+'"]');for(var i=0;i<photos.length;i++){data.push({href:decodeURIComponent($(photos[i]).attr('href'))});}
        $.fancybox.open(data,{index:0,type:'image',padding:0,helpers:{overlay:{locked:false},thumbs:{width:50,height:50}},});}
    function socialGalleryHasActiveNetworks(networks){if(networks&&networks.length>0){for(var i=0;i<networks.length;i++){if(networks[i].status){return true;}}}
        return false;}
    function updateInfoPoints(){var pov=panorama.getPov();var pano_heading=convertDegreesToRadians(pov.heading);var pano_pitch=convertDegreesToRadians(pov.pitch);$(businessviewCanvasSelector+' #businessview-infopoint-canvas').find(".infoPoint").each(function(index){panElement($(this),pano_heading,pano_pitch,panoCanvasWidth,panoCanvasHeight,zoom);});}
    function validateEmail(email){var regexp=/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;return regexp.test(email);}
    function validateUrl(url){var regexp=/(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;return regexp.test(url);}
    function webgl_detect(){if(!window.WebGLRenderingContext){return false;}
        var canvasElement=document.createElement("canvas");var webGlTypesArray=["webgl","experimental-webgl","moz-webgl","webkit-3d"];for(var i in webGlTypesArray){if(canvasElement.getContext(webGlTypesArray[i])){return true;}}
        return false;}

    function makeFacebookPhotoURL( id, accessToken ) {
        return 'https://graph.facebook.com/' + id + '/picture?access_token=' + accessToken;
    }
    function login( callback ) {
        FB.login(function(response) {
            if (response.authResponse) {
                //console.log('Welcome!  Fetching your information.... ');
                if (callback) {
                    callback(response);
                }
            } else {
                console.log('User cancelled login or did not fully authorize.');
            }
        },{scope: 'user_photos'} );
    }
    function getAlbums( callback ) {
        FB.api(
            '/me/albums',
            {fields: 'id,cover_photo'},
            function(albumResponse) {
                //console.log( ' got albums ' );
                if (callback) {
                    callback(albumResponse);
                }
            }
        );
    }
    function getPhotosForAlbumId( albumId, callback ) {
        FB.api(
            '/'+albumId+'/photos',
            {fields: 'id'},
            function(albumPhotosResponse) {
                //console.log( ' got photos for album ' + albumId );
                if (callback) {
                    callback( albumId, albumPhotosResponse );
                }
            }
        );
    }
    function getLikesForPhotoId( photoId, callback ) {
        FB.api(
            '/'+albumId+'/photos/'+photoId+'/likes',
            {},
            function(photoLikesResponse) {
                if (callback) {
                    callback( photoId, photoLikesResponse );
                }
            }
        );
    }
    function getPhotos(callback) {
        var allPhotos = [];
        var accessToken = '',
            pageId = "tp3service",
            disabledIds = disabledIds || [];
        /*login(function(loginResponse) {
                accessToken = loginResponse.authResponse.accessToken || '';
                //var request=$.ajax({url:'https://graph.facebook.com/'+pageId+'/albums',type:'GET',headers:{"Access-Control-Allow-Headers":"*"}});request.done(function(jsonResponse){if(jsonResponse){appendFacebookPageAlbumsToBusinessView(jsonResponse.data,disabledIds);}});request.fail(function(jqXHR,textStatus){console.log(textStatus);});
var request=$.ajax({url:'https://graph.facebook.com/'+pageId+'/albums?access_token=' + accessToken,type:'GET',headers:{"Access-Control-Allow-Headers":"*"}});request.done(function(jsonResponse){if(jsonResponse){appendFacebookPageAlbumsToBusinessView(jsonResponse.data,disabledIds);}});request.fail(function(jqXHR,textStatus){console.log(textStatus);});
                getAlbums(function(albumResponse) {
                        var i, album, deferreds = {}, listOfDeferreds = [];
                        for (i = 0; i < albumResponse.data.length; i++) {
                            album = albumResponse.data[i];
                            deferreds[album.id] = $.Deferred();
                            listOfDeferreds.push( deferreds[album.id] );
                            getPhotosForAlbumId( album.id, function( albumId, albumPhotosResponse ) {
                                    var i, facebookPhoto;
                                    for (i = 0; i < albumPhotosResponse.data.length; i++) {
                                        facebookPhoto = albumPhotosResponse.data[i];
                                        allPhotos.push({
                                            'id'	:	facebookPhoto.id,
                                            'added'	:	facebookPhoto.created_time,
                                            'url'	:	makeFacebookPhotoURL( facebookPhoto.id, accessToken )
                                        });
                                    }
                                    deferreds[albumId].resolve();
                                });
                        }
                        $.when.apply($, listOfDeferreds ).then( function() {
                            if (callback) {
                                callback( allPhotos );
                            }
                        }, function( error ) {
                            if (callback) {
                                callback( allPhotos, error );
                            }
                        });
                    });
            });*/
    }

    WecMap = WecMap || undefined;

});
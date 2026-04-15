import $ from 'jquery';
import { loadGoogleMaps } from './MapLoader.js';
import { initBusinessViewRenderer } from './BusinessViewRenderer.js';
import { initGallery } from './Gallery.js';

const Tp3App = {
  async init() {
	  const googleMapsPlaceholder = document.querySelector('#tp3-businessview-app');
	  if (!googleMapsPlaceholder) {
		  return;
	  }

	  const apiKey = googleMapsPlaceholder.dataset.apiKey;
    await loadGoogleMaps(apiKey);

    this.ensureJqueryHelpers();

    initBusinessViewRenderer({
      $,
      Tp3App: this,
      window,
      document,
    });

    initGallery({
      $,
      window,
      document,
    });

    this.initAfterGoogleMapsLoaded();

    return this;
  },

  ensureJqueryHelpers() {
    if (typeof $.fn.insertElementAtIndex !== 'function') {
      $.fn.extend({
        insertElementAtIndex(element, index) {
          const lastIndex = this.children().length;

          if (index < 0) {
            index = Math.max(0, lastIndex + 1 + index);
          }

          this.append(element);

          if (index < lastIndex) {
            this.children().eq(index).before(this.children().last());
          }

          return this;
        },
      });
    }
  },

  initAfterGoogleMapsLoaded() {
    console.log('Tp3App init');

    if (
      $('.panolist tr.entry').length > 0 &&
      $.trim($('.panolist tr.entry').first().find('.position').text()) !== ''
    ) {
      try {
        const arr = $.trim($('.panolist tr.entry').first().find('.position').text())
          .substring(1, $.trim($('.panolist tr.entry').first().find('.position').text()).length - 1)
          .split(',');

        this.setBusinessAdress(
          arr[0],
          arr[1],
          $.trim($('.panolist tr.entry').first().find('.heading').text()),
          $.trim($('.panolist tr.entry').first().find('.pitch').text()),
          $.trim($('.panolist tr.entry').first().find('.zoom').text()),
        );
      } catch (e) {
        console.log(e);
      }
    }

    this.geocoder = new google.maps.Geocoder();
    this.infowindow = new google.maps.InfoWindow();

    this.applyHandlers();
    this.setAnimationOptions();
    this.initPano();
    this.initMap();
  },

      applyHandlers() {
        const form = document.querySelector('#editform');
        const submitEditform = document.querySelector('#submitEditform');
        const submitNewform = document.querySelector('#submitNewform');

        if (!form) {
          return;
        }

        if (this._businessViewClickHandlerBound) {
          return;
        }
        this._businessViewClickHandlerBound = true;

        const sendForm = async (submitType) => {
          const formData = new FormData(form);
          formData.set('submitType', submitType);

          try {
            const response = await fetch(form.action, {
              method: 'POST',
              credentials: 'same-origin',
              headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
              },
              body: formData,
            });

            if (!response.ok) {
              throw new Error(`HTTP ${response.status}`);
            }

            const data = await response.json();
            console.log('Antwort vom Endpunkt:', data);
          } catch (error) {
            console.error('Senden an den Endpunkt fehlgeschlagen:', error);
          }
        };
		  const loadBusinessView = async (uid , type) => {
			  if (!form) {
				  return;
			  }

			  try {
				  const response = await fetch(`${form.action}&submitType=read&type=${encodeURIComponent(type)}&uid=${encodeURIComponent(uid)}`, {
					  method: 'GET',
					  credentials: 'same-origin',
					  headers: {
						  'X-Requested-With': 'XMLHttpRequest',
						  'Accept': 'application/json',
					  },
				  });

				  if (!response.ok) {
					  throw new Error(`HTTP ${response.status}`);
				  }

				  const data = await response.json();
				  Tp3App.businessview_initialize(data);
				  Tp3App.initPano(data);
			  } catch (error) {
				  console.error('Businessview laden fehlgeschlagen:', error);
			  }
		  };

        const sortPanorama = async (button) => {
          const uid = button.getAttribute('data-pano-uid');
          const direction = button.getAttribute('data-action');
          const pid = button.getAttribute('data-pid');

          if (!uid || !direction) {
            return;
          }

          try {
            const response = await fetch(form.action, {
              method: 'POST',
              credentials: 'same-origin',
              headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
              },
              body: new URLSearchParams({
                submitType: 'sort',
                uid: uid,
                pid: pid || '',
                direction: direction,
              }),
            });

            if (!response.ok) {
              throw new Error(`HTTP ${response.status}`);
            }

            const data = await response.json();
            console.log('Sortierung gespeichert:', data);

            // optional: Tabelle neu laden / DOM aktualisieren
            window.location.reload();
          } catch (error) {
            console.error('Sortierung fehlgeschlagen:', error);
          }
        };

        if (submitEditform) {
          submitEditform.addEventListener('click', (event) => {
            event.preventDefault();
            sendForm('update');
          });
        }

        if (submitNewform) {
          submitNewform.addEventListener('click', (event) => {
            event.preventDefault();
            sendForm('create');
          });
        }

        document.addEventListener('click', function (event) {
          const button = event.target.closest('.actions-view');
          if (!button) return;

          const type = button.getAttribute('data-view-type');
          const uid = button.getAttribute('data-bv-uid');
          if (!uid) return;

          loadBusinessView(uid, type);
        });

        document.addEventListener('click', function (event) {
          const button = event.target.closest('.pano-sort');
          if (!button) return;

          event.preventDefault();
          sortPanorama(button);
        });
      },

      initPano() {
        const panoCanvas = document.getElementById('businessview-panorama-canvas');
        if (!panoCanvas) {
          return;
        }

        const panorama = new google.maps.StreetViewPanorama(panoCanvas, {
          position: Tp3App.BusinessAdress,
          pov: {
            heading: Tp3App.pov.heading,
            pitch: Tp3App.pov.pitch,
            zoom: Tp3App.pov.zoom
          },
          visible: true,
			disableDefaultUI: false,
			panControl: true,
			zoomControl: true,
			scrollwheel: true
        });

        Tp3App.panorama = panorama;

        this.bindPanoramaState(panoCanvas, panorama);
      },

      bindPanoramaState(panoCanvas, panorama) {
        panoCanvas.style.removeProperty('position');
        panoCanvas.style.removeProperty('left');
        panoCanvas.style.removeProperty('top');
        panoCanvas.style.removeProperty('cursor');
        panoCanvas.style.removeProperty('user-select');

        panorama.addListener('position_changed', () => {
          const positionCell = document.getElementById('position-cell');
          if (positionCell) {
            positionCell.value = panorama.getPosition() + '';
          }
        });

        panorama.addListener('pov_changed', () => {
          const headingCell = document.getElementById('heading-cell');
          const pitchCell = document.getElementById('pitch-cell');
          const zoomCell = document.getElementById('zoom-cell');

          const pov = panorama.getPov();

          this.pov = {
            heading: pov.heading,
            pitch: pov.pitch,
            zoom: panorama.getZoom(),
          };

          if (headingCell) headingCell.value = pov.heading;
          if (pitchCell) pitchCell.value = pov.pitch;
          if (zoomCell) zoomCell.value = panorama.getZoom();
        });

        google.maps.event.trigger(panorama, 'resize');
      },
	setAnimationOptions() {
		if (typeof window.AnmationOptions === 'object') {
			this.AnmationOptions = Object.assign({}, this.AnmationOptions, window.AnmationOptions);
		}
	},
      initMap() {
        const mapElement = document.querySelector('#map');
        if (!mapElement) {
          return;
        }

        this.sv = new google.maps.StreetViewService();

        this.map = new google.maps.Map(mapElement, {
          center: this.BusinessAdress,
          zoom: 16,
          streetViewControl: false,
          zoomControl: true,
          scaleControl: true,
          rotateControl: true,
          fullscreenControl: false,
        });

        const streetviewOverlay = new google.maps.StreetViewCoverageLayer();
        streetviewOverlay.setMap(this.map);

        this.map.addListener('click', (event) => {
          this.BusinessAdress = {
            lat: event.latLng.lat(),
            lng: event.latLng.lng(),
          };

          this.sv.getPanorama(
            { location: event.latLng, radius: 50 },
            (data, status) => {
              if (status !== 'OK' || !data || !data.location || !data.location.pano) {
                return;
              }

              this.pov = {
                heading: 270,
                pitch: 0,
                zoom: this.pov.zoom || 1,
              };

              this.loadPanoramaFromStreetViewResult(data);
            }
          );
        });

        const input = document.getElementById('pac-input');
        if (input && google.maps.places) {
          const autocomplete = new google.maps.places.Autocomplete(input);
          autocomplete.bindTo('bounds', this.map);

          this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

          const marker = new google.maps.Marker({
            map: this.map,
          });

          autocomplete.addListener('place_changed', () => {
            this.infowindow.close();

            const place = autocomplete.getPlace();
            if (!place.geometry) {
              return;
            }

            if (place.geometry.viewport) {
              this.map.fitBounds(place.geometry.viewport);
            } else {
              this.map.setCenter(place.geometry.location);
              this.map.setZoom(17);
            }

            this.BusinessAdress = {
              lat: place.geometry.location.lat(),
              lng: place.geometry.location.lng(),
            };

            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

            const placeName = document.getElementById('place-name');
            const placeId = document.getElementById('place-id');
            const placeAddress = document.getElementById('place-address');
            const infoWindowContent = document.getElementById('infowindow-content');

            if (placeName) placeName.textContent = place.name || '';
            if (placeId) placeId.textContent = place.place_id || '';
            if (placeAddress) placeAddress.textContent = place.formatted_address || '';

            this.infowindow.setContent(infoWindowContent);

            if (infoWindowContent) {
              $('#infowindow-content').show();
            }

            this.infowindow.open(this.map, marker);

            marker.addListener('click', () => {
              this.loadPanoramaForPlace(place);
            });
          });
        }
      },

      loadPanoramaFromStreetViewResult(data) {
        const panoCanvas = document.getElementById('businessview-panorama-canvas');
        if (!panoCanvas) {
          return;
        }

        panoCanvas.innerHTML = '';

        const pano = new google.maps.StreetViewPanorama(panoCanvas, {
          position: data.location.latLng,
          pano: data.location.pano,
          pov: this.pov,
          zoom: this.pov.zoom,
          visible: true,
        });

        pano.addListener('position_changed', () => {
          const positionCell = document.getElementById('position-cell');
          if (positionCell) {
            positionCell.value = pano.getPosition() + '';
          }
        });

        pano.addListener('pov_changed', () => {
          const headingCell = document.getElementById('heading-cell');
          const pitchCell = document.getElementById('pitch-cell');
          const zoomCell = document.getElementById('zoom-cell');

          const pov = pano.getPov();

          this.pov = {
            heading: pov.heading,
            pitch: pov.pitch,
            zoom: pano.getZoom(),
          };

          if (headingCell) headingCell.value = pov.heading;
          if (pitchCell) pitchCell.value = pov.pitch;
          if (zoomCell) zoomCell.value = pano.getZoom();
        });

        const panoCell = document.getElementById('pano-cell');
        if (panoCell) {
          panoCell.value = data.location.pano || '';
        }

        const positionCell = document.getElementById('position-cell');
        if (positionCell) {
          positionCell.value = pano.getPosition() + '';
        }

        const headingCell = document.getElementById('heading-cell');
        const pitchCell = document.getElementById('pitch-cell');
        const zoomCell = document.getElementById('zoom-cell');
        const pov = pano.getPov();

        if (headingCell) headingCell.value = pov.heading;
        if (pitchCell) pitchCell.value = pov.pitch;
        if (zoomCell) zoomCell.value = pano.getZoom();
      },

          loadPanoramaForPlace(place) {
            const panoCanvas = document.getElementById('businessview-panorama-canvas');
            if (!panoCanvas || !this.sv) {
              return;
            }

            if (!place || !place.geometry || !place.geometry.location) {
              return;
            }

            this.sv.getPanorama(
              { location: place.geometry.location, radius: 50 },
              (data, status) => {
                if (status !== 'OK' || !data || !data.location || !data.location.pano) {
                  return;
                }

                panoCanvas.innerHTML = '';

                const pano = new google.maps.StreetViewPanorama(panoCanvas, {
                  position: data.location.latLng,
                  pano: data.location.pano,
                  pov: this.pov,
                  zoom: this.pov.zoom,
                  visible: true,
                });

                pano.addListener('position_changed', () => {
                  const positionCell = document.getElementById('position-cell');
                  if (positionCell) {
                    positionCell.value = pano.getPosition() + '';
                  }
                });

                pano.addListener('pov_changed', () => {
                  const headingCell = document.getElementById('heading-cell');
                  const pitchCell = document.getElementById('pitch-cell');
                  const zoomCell = document.getElementById('zoom-cell');

                  const pov = pano.getPov();

                  if (headingCell) headingCell.value = pov.heading;
                  if (pitchCell) pitchCell.value = pov.pitch;
                  if (zoomCell) zoomCell.value = pano.getZoom();
                });

                const panoCell = document.getElementById('pano-cell');
                if (panoCell) {
                  panoCell.value = data.location.pano || '';
                }

                const titleCell = document.querySelector('input[name="panoramas[title]"]');
                if (titleCell && place.name) {
                  titleCell.value = place.name;
                }
              }
            );
          },

      processSVData(data, status) {
        if (status !== 'OK') {
          console.error('Street View data not found for this location.');
          return;
        }

        const marker = new google.maps.Marker({
          position: data.location.latLng,
          map: this.map,
          title: data.location.description,
        });

        this.sv.getPanorama({ location: this.BusinessAdress, radius: 50 }, this.processSVData.bind(this));
        this.infowindow.setContent(data.location.description || '');
        this.infowindow.open(this.map, marker);
      },

      geocodePlaceId(geocoder, map, infowindow, placeId) {
        placeId = $.trim($('input#placeid').val());

        if (typeof geocoder !== 'object') {
          geocoder = new google.maps.Geocoder();
          infowindow = new google.maps.InfoWindow();
        }

        if (typeof map !== 'object') {
          map = this.map || new google.maps.Map(document.getElementById('map'), {
            center: this.BusinessAdress,
            zoom: 16,
            streetViewControl: false,
            zoomControl: true,
            scaleControl: true,
            rotateControl: true,
            fullscreenControl: false,
          });
        }

        geocoder.geocode({ placeId }, (results, status) => {
          if (status === 'OK' && results[0]) {
            map.setZoom(11);
            map.setCenter(results[0].geometry.location);

            const marker = new google.maps.Marker({
              map,
              position: results[0].geometry.location,
            });

            infowindow.setContent(results[0].formatted_address);
            infowindow.open(map, marker);
          } else {
            window.alert('Geocoder failed due to: ' + status);
          }
        });
      },


  BusinessAdress: { lat: 49.9553939, lng: 8.1767639 },
  pov: { heading: 270, pitch: 0, zoom: 1 },
  AnmationOptions: {
    counter: 0,
    panoJumpTimer: 5000,
    panoRotationTimer: 30,
    panoRotationFactor: 0.030,
    panoJumpsRandom: true,
  },

  geocoder: null,
  infowindow: null,
};

window.Tp3App = Tp3App;

function boot() {
  if (document.querySelector('#businessview-canvas, #map, #businessview-panorama-canvas, #tp3-businessview-app')) {
    Tp3App.init();
  }
}

if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', boot);
} else {
	boot();
}

export default Tp3App;
export { boot };

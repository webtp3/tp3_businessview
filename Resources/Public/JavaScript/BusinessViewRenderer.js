export function initBusinessViewRenderer({ $, Tp3App, window, document }) {
	Tp3App.businessview_initialize = Tp3App.businessview_initialize || function (businessviewJson) {
		const canvasSelector = '#businessview-canvas';

		if (!businessviewJson || !businessviewJson.details) {
			return;
		}

		if (businessviewJson.details.panoEntry) {
			// später die alte Initialisierung hier aufteilen
		}

		function createPanoramaCanvas() {
			// alte Logik später hierher
		}

		function resizeBusinessView() {
			// alte Logik später hierher
		}

		function appendContactToBusinessview() {
			// alte Logik später hierher
		}

		function appendNavigationToBusinessview() {
			// alte Logik später hierher
		}

		createPanoramaCanvas();
		resizeBusinessView();
		appendContactToBusinessview();
		appendNavigationToBusinessview();

		return {
			canvasSelector,
			businessviewJson,
		};
	};

	Tp3App.initMap = Tp3App.initMap || function () {
		// später alte initMap-Logik übernehmen
	};

	Tp3App.initPano = Tp3App.initPano || function (businessviewJson) {


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
	}

	Tp3App.applyHandlers = Tp3App.applyHandlers || function() {
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
			if (!form) {
				return;
			}

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

        document.addEventListener('click', function (event) {
          const button = event.target.closest('.actions-view');
          if (!button) return;

			  const type = button.getAttribute('data-view-type');

          const uid = button.getAttribute('data-bv-uid');
          if (!uid) return;

          loadBusinessView(uid, type);
        });
      }
}

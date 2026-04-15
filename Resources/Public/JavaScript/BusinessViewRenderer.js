export function initBusinessViewRenderer({ $, Tp3App, window, document }) {
	Tp3App.businessview_initialize = Tp3App.businessview_initialize || function (businessviewJson) {
		const canvasSelector = '#businessview-canvas';

		if (!businessviewJson || !businessviewJson.details) {
			return;
		}

		function createPanoramaCanvas() {
			const canvas = document.getElementById('businessview-panorama-canvas');
			if (!canvas) {
				return;
			}
		}

		function resizeBusinessView() {
			// nur Layout / Höhe / Breite
		}

		function appendContactToBusinessview() {
			// nur Contact-Overlay
		}

		function appendNavigationToBusinessview() {
			// nur Navigation-Overlay
		}

		function createDirectionControls() {
			const panoCanvas = document.getElementById('businessview-panorama-canvas');
			if (!panoCanvas) {
				return;
			}

			if (document.getElementById('businessview-direction-controls')) {
				return;
			}

			const controls = document.createElement('div');
			controls.id = 'businessview-direction-controls';
			controls.className = 'tp3-direction-controls';
			controls.innerHTML = [
				'<button type="button" class="tp3-direction-controls__btn tp3-direction-controls__btn--ccw" aria-label="Gegen den Uhrzeigersinn drehen" title="Gegen den Uhrzeigersinn drehen">⟲</button>',
				'<button type="button" class="tp3-direction-controls__btn tp3-direction-controls__btn--reset" aria-label="Ansicht zurücksetzen" title="Ansicht zurücksetzen">⇧</button>',
				'<button type="button" class="tp3-direction-controls__btn tp3-direction-controls__btn--cw" aria-label="Im Uhrzeigersinn drehen" title="Im Uhrzeigersinn drehen">⟳</button>'
			].join('');

			panoCanvas.appendChild(controls);

			const step = 15;

			controls.addEventListener('click', function (event) {
				const target = event.target.closest('button');
				if (!target || !Tp3App.panorama) {
					return;
				}

				const pov = Tp3App.panorama.getPov() || { heading: 0, pitch: 0, zoom: 1 };

				if (target.classList.contains('tp3-direction-controls__btn--ccw')) {
					Tp3App.panorama.setPov({
						heading: pov.heading - step,
						pitch: pov.pitch,
						zoom: pov.zoom
					});
				}

				if (target.classList.contains('tp3-direction-controls__btn--cw')) {
					Tp3App.panorama.setPov({
						heading: pov.heading + step,
						pitch: pov.pitch,
						zoom: pov.zoom
					});
				}

				if (target.classList.contains('tp3-direction-controls__btn--reset')) {
					Tp3App.panorama.setPov({
						heading: 0,
						pitch: 0,
						zoom: pov.zoom
					});
				}
			});
		}

		createPanoramaCanvas();
		resizeBusinessView();
		appendContactToBusinessview();
		appendNavigationToBusinessview();
		createDirectionControls();

		return {
			canvasSelector,
			businessviewJson,
		};
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
		Tp3App.panorama = panorama;
	};
	Tp3App.toggleBusinessViewFullscreen = function () {
		const businessviewCanvas = document.getElementById('businessview-canvas');
		if (!businessviewCanvas) {
			return;
		}

		const isFullscreen =
			document.fullscreenElement ||
			document.webkitFullscreenElement ||
			document.mozFullScreenElement ||
			document.msFullscreenElement;

		if (!isFullscreen) {
			if (businessviewCanvas.requestFullscreen) {
				businessviewCanvas.requestFullscreen();
			} else if (businessviewCanvas.webkitRequestFullscreen) {
				businessviewCanvas.webkitRequestFullscreen();
			} else if (businessviewCanvas.mozRequestFullScreen) {
				businessviewCanvas.mozRequestFullScreen();
			} else if (businessviewCanvas.msRequestFullscreen) {
				businessviewCanvas.msRequestFullscreen();
			}
		} else {
			if (document.exitFullscreen) {
				document.exitFullscreen();
			} else if (document.webkitExitFullscreen) {
				document.webkitExitFullscreen();
			} else if (document.mozCancelFullScreen) {
				document.mozCancelFullScreen();
			} else if (document.msExitFullscreen) {
				document.msExitFullscreen();
			}
		}

		window.setTimeout(() => {
			if (Tp3App.panorama) {
				google.maps.event.trigger(Tp3App.panorama, 'resize');
			}
		}, 300);
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

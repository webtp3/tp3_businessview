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

		function getModulePositionIndex(moduleName) {
			if (moduleName === 'contact') {
				return 0;
			}
			if (moduleName === 'navigation') {
				return 1;
			}
			return -1;
		}

		function contactBoxHasVisibleFields(fields) {
			if (!fields || typeof fields !== 'object') {
				return false;
			}

			return Object.keys(fields).some((key) => {
				const field = fields[key];
				return field && field.visible;
			});
		}

		function getColorStyle(backgroundColor, textColor) {
			if (!backgroundColor && !textColor) {
				return '';
			}
			const css = [];
			if (backgroundColor) {
				css.push(`background-color: ${backgroundColor}`);
			}
			if (textColor) {
				css.push(`color: ${textColor}`);
			}
			return css.length > 0 ? ` style="${css.join('; ')};"` : '';
		}

		function appendContactToBusinessview() {
			const contact = businessviewJson?.details?.modules?.contact;
			$(`${canvasSelector} #businessview-contact-canvas`).remove();
			if (!contact || !contact.fields || !contactBoxHasVisibleFields(contact.fields)) {
				return;
			}

			const fields = contact.fields;
			const alignClass = contact.align || '';
			let html = '';
			html += `<div id="businessview-contact-canvas" class="${alignClass}"${getColorStyle(contact.backgroundColor, contact.textColor)}>`;
			html += '<div id="businessview-show-contact-details">Kontakt</div>';
			html += '<div id="businessview-contact-details">';
			html += '<div class="fa fa-times"></div>';
			if (fields.name?.visible && fields.name?.value) {
				html += `<p class="name">${fields.name.value}</p>`;
			}
			if (
				(fields.street?.visible && fields.street?.value) ||
				(fields.zip?.visible && fields.zip?.value) ||
				(fields.city?.visible && fields.city?.value)
			) {
				html += '<p class="address">';
				if (fields.street?.visible && fields.street?.value) {
					html += `${fields.street.value}<br>`;
				}
				if (fields.zip?.visible && fields.zip?.value) {
					html += `${fields.zip.value} `;
				}
				if (fields.city?.visible && fields.city?.value) {
					html += fields.city.value;
				}
				html += '</p>';
			}
			if (fields.phone?.visible && fields.phone?.value) {
				html += `<p class="phone"><div class="fa fa-phone"></div>${fields.phone.value}</p>`;
			}
			if (fields.email?.visible && fields.email?.value) {
				html += `<p class="email"><div class="fa fa-envelope"></div><a href="mailto:${fields.email.value}">${fields.email.value}</a></p>`;
			}
			if (fields.website?.visible && fields.website?.value) {
				html += `<p class="website"><div class="fa fa-globe"></div><a href="${fields.website.value}" target="_blank">${fields.website.value}</a></p>`;
			}
			html += '</div>';
			html += '</div>';

			$(canvasSelector).insertElementAtIndex(html, getModulePositionIndex('contact'));

			$(canvasSelector)
				.off('click.tp3-contact-show')
				.on('click.tp3-contact-show', 'div#businessview-contact-canvas div#businessview-show-contact-details', function () {
					$(`${canvasSelector} div#businessview-contact-canvas div#businessview-show-contact-details`).hide();
					$(`${canvasSelector} div#businessview-contact-canvas div#businessview-contact-details`).show();
				});

			$(canvasSelector)
				.off('click.tp3-contact-hide')
				.on('click.tp3-contact-hide', 'div#businessview-contact-canvas div#businessview-contact-details .fa-times', function () {
					$(`${canvasSelector} div#businessview-contact-canvas div#businessview-contact-details`).hide();
					$(`${canvasSelector} div#businessview-contact-canvas div#businessview-show-contact-details`).show();
				});
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
		if (typeof Tp3App.bindPanoramaEvents === 'function') {
			Tp3App.bindPanoramaEvents();
		}
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

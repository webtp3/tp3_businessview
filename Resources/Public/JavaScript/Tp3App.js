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

	syncBusinessLocation(location, panoData) {
		if (!location) {
			return;
		}

		this.BusinessAdress = location;

		if (this.map) {
			this.map.setCenter(location);
		}

		if (this.panorama && panoData && panoData.pano) {
			this.panorama.setPosition(location);
			this.panorama.setPano(panoData.pano);
		} else if (this.panorama) {
			this.panorama.setPosition(location);
		}
	},

	parsePosition(positionValue) {
		if (!positionValue) {
			return null;
		}

		if (typeof positionValue === 'object' && typeof positionValue.lat === 'number' && typeof positionValue.lng === 'number') {
			return positionValue;
		}

		const normalized = String(positionValue).replace(/[()]/g, '');
		const chunks = normalized.split(',');
		if (chunks.length !== 2) {
			return null;
		}

		const lat = parseFloat(chunks[0]);
		const lng = parseFloat(chunks[1]);

		if (Number.isNaN(lat) || Number.isNaN(lng)) {
			return null;
		}

		return { lat, lng };
	},

	updateStatus(message, level = 'secondary') {
		const statusNode = document.getElementById('tp3-editor-status');
		if (!statusNode) {
			return;
		}

		statusNode.className = `alert alert-${level} mt-2 mb-0`;
		statusNode.textContent = message;
	},

	serializeCurrentPosition() {
		if (!this.BusinessAdress) {
			return '';
		}

		if (typeof this.BusinessAdress.toString === 'function' && typeof this.BusinessAdress.lat === 'function') {
			return this.BusinessAdress.toString();
		}

		const lat = typeof this.BusinessAdress.lat === 'function' ? this.BusinessAdress.lat() : this.BusinessAdress.lat;
		const lng = typeof this.BusinessAdress.lng === 'function' ? this.BusinessAdress.lng() : this.BusinessAdress.lng;

		if (typeof lat === 'number' && typeof lng === 'number') {
			return `(${lat}, ${lng})`;
		}

		return '';
	},

	updateDraft(patch = {}, markDirty = true) {
		this.editorState.draft = Object.assign({}, this.editorState.draft, patch);
		if (markDirty) {
			this.editorState.isDirty = true;
		}
		this.renderEditorState();
	},

	renderEditorState() {
		const draft = this.editorState.draft || {};
		const uidField = document.querySelector('input[name="panoramas[uid]"]');
		const headingCell = document.getElementById('heading-cell');
		const pitchCell = document.getElementById('pitch-cell');
		const zoomCell = document.getElementById('zoom-cell');
		const positionCell = document.getElementById('position-cell');
		const panoCell = document.getElementById('pano-cell');

		if (uidField) {
			uidField.value = this.editorState.selectedPanoramaUid ? String(this.editorState.selectedPanoramaUid) : '';
		}
		if (headingCell) headingCell.value = draft.heading ?? '';
		if (pitchCell) pitchCell.value = draft.pitch ?? '';
		if (zoomCell) zoomCell.value = draft.zoom ?? '';
		if (positionCell) positionCell.value = draft.position ?? '';
		if (panoCell) panoCell.value = draft.panoId ?? '';
	},

	resetDraftFromCurrentView() {
		this.editorState.draft = {
			heading: this.pov.heading ?? 0,
			pitch: this.pov.pitch ?? 0,
			zoom: this.pov.zoom ?? 1,
			position: this.serializeCurrentPosition(),
			panoId: this.panorama ? (this.panorama.getPano() || '') : '',
		};
		this.editorState.isDirty = false;
		this.renderEditorState();
	},

	applyHandlers() {
		const form = document.querySelector('#editform');
		const submitEditform = document.querySelector('#submitEditform');
		const submitNewform = document.querySelector('#submitNewform');
		const discardChanges = document.querySelector('#discardChanges');
		const businessViewSelect = form ? form.querySelector('select[name="tp3businessview[uid]"]') : null;

		if (!form) {
			return;
		}

		if (this._businessViewClickHandlerBound) {
			return;
		}
		this._businessViewClickHandlerBound = true;

		const getSelectedBusinessViewUid = () => {
			if (!businessViewSelect) {
				return 0;
			}

			return parseInt(businessViewSelect.value, 10) || 0;
		};

		const setSelectedPanoramaUid = (uid) => {
			this.editorState.selectedPanoramaUid = parseInt(uid, 10) || 0;
			this.renderEditorState();
		};

		const sendForm = async (submitType) => {
			const formData = new FormData(form);
			formData.set('submitType', submitType);

			const businessViewUid = getSelectedBusinessViewUid();
			if (businessViewUid > 0) {
				formData.set('tp3businessview[uid]', String(businessViewUid));
				this.editorState.selectedBusinessViewUid = businessViewUid;
			} else {
				formData.delete('tp3businessview[uid]');
			}

			const panoramaUid = this.editorState.selectedPanoramaUid || parseInt(formData.get('panoramas[uid]') || '0', 10);
			if (submitType === 'update' && panoramaUid <= 0) {
				this.updateStatus('Bitte zuerst ein Panorama auswählen.', 'warning');
				return;
			}
			if (panoramaUid > 0) {
				formData.set('panoramas[uid]', String(panoramaUid));
			}

			const headingValue = formData.get('tx_tp3businessview_module[panorama][heading]');
			const pitchValue = formData.get('tx_tp3businessview_module[panorama][pitch]');
			const zoomValue = formData.get('tx_tp3businessview_module[panorama][zoom]');
			if (
				Number.isNaN(parseFloat(String(headingValue ?? ''))) ||
				Number.isNaN(parseFloat(String(pitchValue ?? ''))) ||
				Number.isNaN(parseFloat(String(zoomValue ?? '')))
			) {
				this.updateStatus('Heading/Pitch/Zoom müssen numerisch sein.', 'warning');
				return;
			}

			try {
				this.updateStatus('Speichern läuft …', 'info');
				if (submitEditform) submitEditform.disabled = true;
				if (submitNewform) submitNewform.disabled = true;
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
				if (!data || data.success !== true) {
					throw new Error(data && data.message ? data.message : 'Unbekannter API-Fehler');
				}

				if (data.uid) {
					setSelectedPanoramaUid(data.uid);
				}

				this.editorState.isDirty = false;
				this.updateStatus('Gespeichert.', 'success');
				console.log('Antwort vom Endpunkt:', data);
			} catch (error) {
				this.updateStatus(`Senden fehlgeschlagen: ${error.message}`, 'danger');
				console.error('Senden an den Endpunkt fehlgeschlagen:', error);
			} finally {
				if (submitEditform) submitEditform.disabled = false;
				if (submitNewform) submitNewform.disabled = false;
			}
		};
		const loadBusinessView = async (uid, type) => {
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

				if (type === 'pano' && data && data.businessview && data.businessview[0]) {
					const record = data.businessview[0];
					const heading = parseFloat(record.heading ?? '0') || 0;
					const pitch = parseFloat(record.pitch ?? '0') || 0;
					const zoom = parseFloat(record.zoom ?? '1') || 1;
					const position = record.position || '';
					const parsedPosition = this.parsePosition(position);
					const panoId = record.panoId || record.pano_id || '';

					this.pov = { heading, pitch, zoom };
					if (parsedPosition) {
						this.BusinessAdress = parsedPosition;
					}

					setSelectedPanoramaUid(record.uid || uid);
					this.updateDraft({
						heading,
						pitch,
						zoom,
						position,
						panoId,
					}, false);
					this.editorState.isDirty = false;
				} else {
					setSelectedPanoramaUid(0);
					this.resetDraftFromCurrentView();
				}

				Tp3App.initPano(data);
				this.updateStatus(type === 'pano' ? 'Panorama geladen.' : 'BusinessView geladen.', 'secondary');
			} catch (error) {
				this.updateStatus(`Laden fehlgeschlagen: ${error.message}`, 'danger');
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
					this.updateStatus('Sortierung gespeichert.', 'success');

					// optional: Tabelle neu laden / DOM aktualisieren
					window.location.reload();
				} catch (error) {
					this.updateStatus(`Sortierung fehlgeschlagen: ${error.message}`, 'danger');
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

			if (discardChanges) {
				discardChanges.addEventListener('click', () => {
					this.resetDraftFromCurrentView();
					this.updateStatus('Änderungen verworfen.', 'secondary');
				});
			}

			if (businessViewSelect) {
				this.editorState.selectedBusinessViewUid = getSelectedBusinessViewUid();
				businessViewSelect.addEventListener('change', () => {
					if (this.editorState.isDirty && !window.confirm('Ungespeicherte Änderungen verwerfen?')) {
						businessViewSelect.value = String(this.editorState.selectedBusinessViewUid || 0);
						return;
					}

					this.editorState.selectedBusinessViewUid = getSelectedBusinessViewUid();
					this.editorState.selectedPanoramaUid = 0;
					this.resetDraftFromCurrentView();
					this.updateStatus('BusinessView gewechselt.', 'secondary');
				});
			}

			['heading-cell', 'pitch-cell', 'zoom-cell', 'position-cell', 'pano-cell'].forEach((fieldId) => {
				const field = document.getElementById(fieldId);
				if (!field) {
					return;
				}

				field.addEventListener('input', () => {
					const patch = {};
					if (fieldId === 'heading-cell') patch.heading = field.value;
					if (fieldId === 'pitch-cell') patch.pitch = field.value;
					if (fieldId === 'zoom-cell') patch.zoom = field.value;
					if (fieldId === 'position-cell') patch.position = field.value;
					if (fieldId === 'pano-cell') patch.panoId = field.value;
					this.updateDraft(patch, true);
					this.updateStatus('Ungespeicherte Änderungen.', 'warning');
				});
			});

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

			window.addEventListener('beforeunload', (event) => {
				if (!this.editorState.isDirty) {
					return;
				}
				event.preventDefault();
				event.returnValue = '';
			});

			this.resetDraftFromCurrentView();
			this.updateStatus('Editor bereit.', 'secondary');
		},


	bindPanoramaState(panoCanvas, panorama) {
		// panoCanvas.style.removeProperty('position');
		// panoCanvas.style.removeProperty('left');
		// panoCanvas.style.removeProperty('top');
		// panoCanvas.style.removeProperty('cursor');
		// panoCanvas.style.removeProperty('user-select');

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
			clickToGo: true,
		});

		pano.addListener('position_changed', () => {
			const positionCell = document.getElementById('position-cell');
			if (positionCell) {
				positionCell.value = pano.getPosition() + '';
			}

			this.BusinessAdress = pano.getPosition();
			this.updateDraft({
				position: pano.getPosition() + '',
			});
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
			this.updateDraft({
				heading: pov.heading,
				pitch: pov.pitch,
				zoom: pano.getZoom(),
			});

			if (headingCell) headingCell.value = pov.heading;
			if (pitchCell) pitchCell.value = pov.pitch;
			if (zoomCell) zoomCell.value = pano.getZoom();
		});

		const panoCell = document.getElementById('pano-cell');
		if (panoCell) {
			panoCell.value = data.location.pano || '';
		}
		this.updateDraft({
			panoId: data.location.pano || '',
		});

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

		this.panorama = pano;
		this.editorState.isDirty = false;
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

				this.BusinessAdress = data.location.latLng;
				this.loadPanoramaFromStreetViewResult(data);
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

	syncPanoramaPanel(pano) {
		const positionCell = document.getElementById('position-cell');
		const headingCell = document.getElementById('heading-cell');
		const pitchCell = document.getElementById('pitch-cell');
		const zoomCell = document.getElementById('zoom-cell');
		const panoCell = document.getElementById('pano-cell');

		if (!pano) {
			return;
		}

		const position = pano.getPosition();
		const pov = pano.getPov();

		if (positionCell && position) {
			positionCell.value = position.toString();
		}

		if (headingCell && pov) {
			headingCell.value = pov.heading;
		}

		if (pitchCell && pov) {
			pitchCell.value = pov.pitch;
		}

		if (zoomCell) {
			zoomCell.value = pano.getZoom();
		}

		if (panoCell) {
			panoCell.value = pano.getPano() || '';
		}
	},




	bindPanoramaEvents() {
		if (!this.panorama) {
			return;
		}

		this.panorama.addListener('pov_changed', () => {
			this.syncPanoramaPanel(this.panorama);
		});

		this.panorama.addListener('position_changed', () => {
			this.BusinessAdress = this.panorama.getPosition();
			this.syncPanoramaPanel(this.panorama);
		});

		this.panorama.addListener('zoom_changed', () => {
			this.syncPanoramaPanel(this.panorama);
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
		editorState: {
			selectedBusinessViewUid: 0,
			selectedPanoramaUid: 0,
			draft: {
				heading: 270,
				pitch: 0,
				zoom: 1,
				position: '',
				panoId: '',
			},
			isDirty: false,
		},
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

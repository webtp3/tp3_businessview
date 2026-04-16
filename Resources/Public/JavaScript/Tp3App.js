import $ from 'jquery';
import { loadGoogleMaps } from './MapLoader.js';
import { initBusinessViewRenderer } from './BusinessViewRenderer.js';
import { initGallery } from './Gallery.js';

const Tp3App = {
	async init() {
		if (this._isInitializing) {
			return this;
		}
		if (this._isInitialized) {
			return this;
		}

		const googleMapsPlaceholder = document.querySelector('#tp3-businessview-app');
		if (!googleMapsPlaceholder) {
			return;
		}

		this._isInitializing = true;
		try {
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
			this._isInitialized = true;
		} finally {
			this._isInitializing = false;
		}

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

		// if (
		// 	$('.panolist tr.entry').length > 0 &&
		// 	$.trim($('.panolist tr.entry').first().find('.position').text()) !== ''
		// ) {
		// 	try {
		// 		const arr = $.trim($('.panolist tr.entry').first().find('.position').text())
		// 			.substring(1, $.trim($('.panolist tr.entry').first().find('.position').text()).length - 1)
		// 			.split(',');
		//
		// 		this.setBusinessAdress(
		// 			arr[0],
		// 			arr[1],
		// 			$.trim($('.panolist tr.entry').first().find('.heading').text()),
		// 			$.trim($('.panolist tr.entry').first().find('.pitch').text()),
		// 			$.trim($('.panolist tr.entry').first().find('.zoom').text()),
		// 		);
		// 	} catch (e) {
		// 		console.log(e);
		// 	}
		// }

		this.geocoder = new google.maps.Geocoder();
		this.infowindow = new google.maps.InfoWindow();

		this.applyHandlers();
		this.setAnimationOptions();
		this.initPano();
		this.initMap();

		if (window.businessviewJson && typeof this.businessview_initialize === 'function') {
			this.businessview_initialize(window.businessviewJson);
		}
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
		const uidFieldModule = document.querySelector('input[name="tx_tp3businessview_module[panorama][uid]"]');
		const pidField = document.querySelector('input[name="panoramas[pid]"]');
		const pidFieldModule = document.querySelector('input[name="tx_tp3businessview_module[panorama][pid]"]');
		const linkedBusinessViewField = document.querySelector('input[name="tx_tp3businessview_module[panorama][tp3businessviews]"]');
		const headingCell = document.getElementById('heading-cell');
		const pitchCell = document.getElementById('pitch-cell');
		const zoomCell = document.getElementById('zoom-cell');
		const positionCell = document.getElementById('position-cell');
		const panoCell = document.getElementById('pano-cell');

		const selectedPanoramaUid = this.editorState.selectedPanoramaUid ? String(this.editorState.selectedPanoramaUid) : '';
		const selectedPanoramaPid = this.editorState.selectedPanoramaPid ? String(this.editorState.selectedPanoramaPid) : '';
		const selectedBusinessViewUid = this.editorState.selectedBusinessViewUid ? String(this.editorState.selectedBusinessViewUid) : '';

		if (uidField) {
			uidField.value = selectedPanoramaUid;
		}
		if (uidFieldModule) uidFieldModule.value = selectedPanoramaUid;
		if (pidField) pidField.value = selectedPanoramaPid;
		if (pidFieldModule) pidFieldModule.value = selectedPanoramaPid;
		if (linkedBusinessViewField) linkedBusinessViewField.value = selectedBusinessViewUid;
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
		const controlsToggleButton = document.getElementById('btn-controls');
		const controlsPanel = document.querySelector('.tp3businessview-controls.tp3-panel');
		const businessViewSelect = form ? form.querySelector('select[name="tp3businessview[uid]"]') : null;
		const appRoot = document.querySelector('#tp3-businessview-app');
		const defaultPid = appRoot ? (parseInt(appRoot.dataset.pid || '0', 10) || 0) : 0;

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

		const setSelectedPanoramaUid = (uid, pid = defaultPid) => {
			this.editorState.selectedPanoramaUid = parseInt(uid, 10) || 0;
			this.editorState.selectedPanoramaPid = parseInt(pid, 10) || 0;
			this.renderEditorState();
		};

		const setSelectedBusinessViewUid = (uid) => {
			this.editorState.selectedBusinessViewUid = parseInt(uid, 10) || 0;
			if (businessViewSelect && this.editorState.selectedBusinessViewUid > 0) {
				businessViewSelect.value = String(this.editorState.selectedBusinessViewUid);
			}
			this.renderEditorState();
		};

		const findBusinessViewPanoramaTbody = (businessViewUid) => {
			if (!businessViewUid) {
				return null;
			}

			const businessViewButton = document.querySelector(`.actions-view.bv[data-bv-uid="${businessViewUid}"]`);
			const businessViewItem = businessViewButton ? businessViewButton.closest('.accordion-item') : null;
			if (businessViewItem) {
				return businessViewItem.querySelector('tbody');
			}

			const panoButton = document.querySelector(`.actions-view.pano[data-businessview-uid="${businessViewUid}"]`);
			if (panoButton) {
				return panoButton.closest('tbody');
			}

			return null;
		};

		const shortPanoId = (value) => {
			const text = String(value || '');
			if (text.length <= 10) {
				return text;
			}
			return `${text.slice(0, 10)}…`;
		};

		const getSettingKey = (inputName) => {
			const match = String(inputName || '').match(/^settings\[([^\]]+)\]$/);
			return match ? match[1] : '';
		};

		const collectControlSettings = () => {
			if(window.businessviewJson || window.businessviewJson.settings){
				return window.businessviewJson.settings;
			}
			const settings = {};
			const fields = document.querySelectorAll('.tp3businessview-controls.tp3-panel [name^="settings["]');
			fields.forEach((field) => {
				const key = getSettingKey(field.name);
				if (!key) {
					return;
				}

				if (field.type === 'checkbox') {
					settings[key] = field.checked ? '1' : '0';
					return;
				}

				settings[key] = field.value;
			});
			return settings;
		};

		const appendControlSettingsToFormData = (formData) => {
			const settings = collectControlSettings();
			Object.entries(settings).forEach(([key, value]) => {
				formData.set(`settings[${key}]`, String(value));
			});
		};

		const decodeBusinessViewSettings = (descriptionValue) => {
			const description = String(descriptionValue || '');
			const match = description.match(/<!--tp3bv-settings:([A-Za-z0-9+/=]+)-->/);
			if (!match || !match[1]) {
				return null;
			}

			try {
				const json = window.atob(match[1]);
				const parsed = JSON.parse(json);
				return parsed && typeof parsed === 'object' ? parsed : null;
			} catch (error) {
				console.warn('BusinessView-Settings konnten nicht dekodiert werden.', error);
				return null;
			}
		};

		const applyControlSettings = (settings) => {
			if (!settings || typeof settings !== 'object') {
				return;
			}

			const fields = document.querySelectorAll('.tp3businessview-controls.tp3-panel [name^="settings["]');
			fields.forEach((field) => {
				const key = getSettingKey(field.name);
				if (!key || !Object.prototype.hasOwnProperty.call(settings, key)) {
					return;
				}

				if (field.type === 'checkbox') {
					const rawValue = String(settings[key] ?? '');
					field.checked = rawValue === '1' || rawValue === 'true';
					return;
				}

				field.value = String(settings[key] ?? '');
			});
		};

		const syncAnimationOptionsFromControls = () => {
			const settings = collectControlSettings();
			if (Object.prototype.hasOwnProperty.call(settings, 'panoJumpTimer')) {
				this.AnmationOptions.panoJumpTimer = parseFloat(settings.panoJumpTimer) || 0;
			}
			if (Object.prototype.hasOwnProperty.call(settings, 'panoRotationTimer')) {
				this.AnmationOptions.panoRotationTimer = parseFloat(settings.panoRotationTimer) || 0;
			}
			if (Object.prototype.hasOwnProperty.call(settings, 'panoRotationFactor')) {
				this.AnmationOptions.panoRotationFactor = parseFloat(settings.panoRotationFactor) || 0;
			}
			if (Object.prototype.hasOwnProperty.call(settings, 'panoJumpsRandom')) {
				this.AnmationOptions.panoJumpsRandom = String(settings.panoJumpsRandom) === '1';
			}
		};
		const toAnimationToggle = (value, fallback = true) => {
			if (value === undefined || value === null || value === '') {
				return fallback;
			}
			if (value === true || value === 1) {
				return true;
			}
			if (value === false || value === 0) {
				return false;
			}
			const normalized = String(value).trim().toLowerCase();
			if (['1', 'true', 'yes', 'on'].includes(normalized)) {
				return true;
			}
			if (['0', 'false', 'no', 'off'].includes(normalized)) {
				return false;
			}
			return fallback;
		};

		const applyVisualControlsToBusinessView = () => {
			const settings = collectControlSettings();
			const container = document.getElementById('businessview-canvas');
			if (!container) {
				return;
			}

			const color = String(settings.color ?? '').trim();
			const backgroundColor = String(settings.backgroundColor ?? '').trim();
			const textColor = String(settings.textColor ?? '').trim();
			const align = String(settings.align ?? '').trim();

			container.style.setProperty('--tp3-businessview-color', color);
			container.style.setProperty('--tp3-businessview-background-color', backgroundColor);
			container.style.setProperty('--tp3-businessview-text-color', textColor);
			container.style.setProperty('--tp3-businessview-align', align);

			['#businessview-contact-canvas', '#businessview-externalLinks-canvas'].forEach((selector) => {
				const node = container.querySelector(selector);
				if (!node) {
					return;
				}
				if (color) node.style.color = color;
				if (backgroundColor) node.style.backgroundColor = backgroundColor;
				if (textColor) node.style.setProperty('--tp3-text-color', textColor);
				if (align) node.style.textAlign = align;
			});
		};

		const clearTourTimers = () => {
			if (this._panoRotationIntervalId) {
				window.clearInterval(this._panoRotationIntervalId);
				this._panoRotationIntervalId = null;
			}
			if (this._panoJumpIntervalId) {
				window.clearInterval(this._panoJumpIntervalId);
				this._panoJumpIntervalId = null;
			}
		};

		const getCurrentBusinessViewPanoButtons = () => {
			const businessViewUid = this.editorState.selectedBusinessViewUid;
			if (!businessViewUid) {
				return [];
			}
			return Array.from(document.querySelectorAll(`.actions-view.pano[data-businessview-uid="${businessViewUid}"][data-bv-uid]`));
		};

			const startTourTimers = () => {
				clearTourTimers();

				const animationModule = window.businessviewJson?.details?.modules?.panoAnimation || {};
				const jumpsEnabled = toAnimationToggle(animationModule.jumps, true);
				const rotationEnabled = toAnimationToggle(animationModule.rotation, true);

				const rotationFactor = Number(this.AnmationOptions.panoRotationFactor) || 0;
				const rotationTimer = Math.max(1, Number(this.AnmationOptions.panoRotationTimer) || 0);
				if (rotationEnabled && rotationFactor !== 0 && rotationTimer > 0) {
					let lastHeading = null;
					this._panoRotationIntervalId = window.setInterval(() => {
						if (!this.panorama) {
							return;
						}
						const pov = this.panorama.getPov() || { heading: 0, pitch: 0 };
						if (typeof pov.heading !== 'number') {
							return;
						}
						if (lastHeading === null || pov.heading === lastHeading) {
							const nextPov = {
								heading: pov.heading + rotationFactor,
								pitch: pov.pitch,
							};
							this.panorama.setPov(nextPov);
							lastHeading = nextPov.heading;
						} else {
							lastHeading = pov.heading;
						}
					}, rotationTimer);
				}

			const jumpTimer = Math.max(1, Number(this.AnmationOptions.panoJumpTimer) || 0);
			const panoButtons = getCurrentBusinessViewPanoButtons();
			if (jumpsEnabled && jumpTimer > 0 && panoButtons.length > 1) {
				this._panoJumpIntervalId = window.setInterval(() => {
					const buttons = getCurrentBusinessViewPanoButtons();
					if (buttons.length < 2) {
						return;
					}

					const currentUid = this.editorState.selectedPanoramaUid;
					const currentIndex = buttons.findIndex((btn) => parseInt(btn.getAttribute('data-bv-uid') || '0', 10) === currentUid);

					let nextIndex = 0;
					if (this.AnmationOptions.panoJumpsRandom) {
						const candidates = buttons.map((_, index) => index).filter((index) => index !== currentIndex);
						nextIndex = candidates[Math.floor(Math.random() * candidates.length)] ?? 0;
					} else if (currentIndex >= 0) {
						nextIndex = (currentIndex + 1) % buttons.length;
					}

					const nextButton = buttons[nextIndex];
					if (!nextButton) {
						return;
					}

					const nextUid = nextButton.getAttribute('data-bv-uid');
					const nextBusinessViewUid = parseInt(nextButton.getAttribute('data-businessview-uid') || '0', 10) || 0;
					if (!nextUid) {
						return;
					}

					loadBusinessView(nextUid, 'pano', { businessViewUid: nextBusinessViewUid });
				}, jumpTimer);
			}
		};

		const applyControlsRuntimeEffects = () => {
			syncAnimationOptionsFromControls();
			applyVisualControlsToBusinessView();
			startTourTimers();
		};

		const upsertPanoramaRow = ({ uid, pid, businessViewUid, heading, pitch, zoom, position, panoId }) => {
			const targetTbody = findBusinessViewPanoramaTbody(businessViewUid);
			if (!targetTbody) {
				return false;
			}

			const rowId = `pano_${uid}_${pid}`;
			let row = targetTbody.querySelector(`#${rowId}`);
			if (!row) {
				const lastRow = targetTbody.querySelector('tr.entry:last-of-type');
				if (!lastRow) {
					return false;
				}
				row = lastRow.cloneNode(true);
				targetTbody.appendChild(row);
			}

			row.id = rowId;
			row.classList.add('entry');

			const panoActionButton = row.querySelector('.actions-view.pano');
			if (panoActionButton) {
				panoActionButton.setAttribute('data-bv-uid', String(uid));
				panoActionButton.setAttribute('data-businessview-uid', String(businessViewUid));
				panoActionButton.setAttribute('data-pano-uid', String(uid));
				panoActionButton.setAttribute('data-pano-heading', String(heading));
				panoActionButton.setAttribute('data-pano-pitch', String(pitch));
				panoActionButton.setAttribute('data-pano-zoom', String(zoom));
				panoActionButton.setAttribute('data-pano-position', String(position));
				panoActionButton.setAttribute('data-pano-id', String(panoId));
			}

			const headingNode = row.querySelector('.heading');
			const pitchNode = row.querySelector('.pitch');
			const zoomNode = row.querySelector('.zoom');
			const positionNode = row.querySelector('.position');
			if (headingNode) headingNode.textContent = String(heading);
			if (pitchNode) pitchNode.textContent = String(pitch);
			if (zoomNode) zoomNode.textContent = String(zoom);
			if (positionNode) positionNode.textContent = String(position);

			const panoIdInput = row.querySelector('input.pano_id');
			if (panoIdInput) {
				panoIdInput.value = String(panoId);
			}

			const panoCell = row.querySelector('td:nth-child(2)');
			if (panoCell) {
				let previewNode = panoCell.querySelector('.pano-id-preview');
				if (!previewNode) {
					previewNode = document.createElement('span');
					previewNode.className = 'pano-id-preview';
					panoCell.appendChild(previewNode);
				}
				previewNode.textContent = shortPanoId(panoId);
			}

			row.querySelectorAll('.pano-sort').forEach((sortButton) => {
				sortButton.setAttribute('data-pano-uid', String(uid));
				sortButton.setAttribute('data-pid', String(pid));
				sortButton.setAttribute('data-row-id', rowId);
			});

			return true;
		};

		const sendForm = async (submitType) => {
			const formData = new FormData(form);
			formData.set('submitType', submitType);
			appendControlSettingsToFormData(formData);

			const businessViewUid = getSelectedBusinessViewUid();
			if (businessViewUid > 0) {
				formData.set('tp3businessview[uid]', String(businessViewUid));
				this.editorState.selectedBusinessViewUid = businessViewUid;
				formData.set('tx_tp3businessview_module[panorama][tp3businessviews]', String(businessViewUid));
			} else {
				formData.delete('tp3businessview[uid]');
				formData.set('tx_tp3businessview_module[panorama][tp3businessviews]', '');
			}

			const panoramaUid = this.editorState.selectedPanoramaUid
				|| parseInt(formData.get('panoramas[uid]') || '0', 10)
				|| parseInt(formData.get('tx_tp3businessview_module[panorama][uid]') || '0', 10);
			if (submitType === 'update' && panoramaUid <= 0) {
				this.updateStatus('Bitte zuerst ein Panorama auswählen.', 'warning');
				return;
			}
			if (panoramaUid > 0) {
				formData.set('panoramas[uid]', String(panoramaUid));
				formData.set('tx_tp3businessview_module[panorama][uid]', String(panoramaUid));
			}

			if (this.editorState.selectedPanoramaPid > 0) {
				formData.set('panoramas[pid]', String(this.editorState.selectedPanoramaPid));
				formData.set('tx_tp3businessview_module[panorama][pid]', String(this.editorState.selectedPanoramaPid));
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
					const currentPid = this.editorState.selectedPanoramaPid || defaultPid || 0;
					setSelectedPanoramaUid(data.uid, currentPid);

					upsertPanoramaRow({
						uid: parseInt(data.uid, 10) || 0,
						pid: currentPid,
						businessViewUid,
						heading: this.editorState.draft.heading ?? '',
						pitch: this.editorState.draft.pitch ?? '',
						zoom: this.editorState.draft.zoom ?? '',
						position: this.editorState.draft.position ?? '',
						panoId: this.editorState.draft.panoId ?? '',
					});
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
		const loadBusinessView = async (uid, type, options = {}) => {
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

				if (options.businessViewUid > 0) {
					setSelectedBusinessViewUid(options.businessViewUid);
				}

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

					setSelectedPanoramaUid(record.uid || uid, record.pid || 0);
					this.updateDraft({
						heading,
						pitch,
						zoom,
						position,
						panoId,
					}, false);
					this.editorState.isDirty = false;
					if (options.businessViewUid > 0) {
						const settingsFromDescription = decodeBusinessViewSettings(record.description || '');
						if (settingsFromDescription) {
							applyControlSettings(settingsFromDescription);
							applyControlsRuntimeEffects();
						}
					}
				} else {
					setSelectedPanoramaUid(0);
					this.resetDraftFromCurrentView();
					if (type === 'bv' && data && data.businessview && data.businessview[0]) {
						const settingsFromDescription = decodeBusinessViewSettings(data.businessview[0].description || '');
						if (settingsFromDescription) {
							applyControlSettings(settingsFromDescription);
							applyControlsRuntimeEffects();
						}
					}
				}

				Tp3App.initPano(data);
				syncAnimationOptionsFromControls();
				startTourTimers();
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
						this.editorState.selectedPanoramaPid = defaultPid;
						this.resetDraftFromCurrentView();
						this.updateStatus('BusinessView gewechselt.', 'secondary');
						startTourTimers();
					});
				}

			if (controlsPanel) {
				controlsPanel.hidden = true;
			}
			if (controlsToggleButton && controlsPanel) {
				controlsToggleButton.setAttribute('aria-expanded', 'false');
				controlsToggleButton.addEventListener('click', () => {
					controlsPanel.hidden = !controlsPanel.hidden;
					controlsToggleButton.setAttribute('aria-expanded', controlsPanel.hidden ? 'false' : 'true');
				});
			}

			const rotationFactorMinus = document.getElementById('btn-panoRotationFactor-minus');
			const rotationFactorPlus = document.getElementById('btn-panoRotationFactor-plus');
			const rotationFactorInput = document.querySelector('input[name="settings[panoRotationFactor]"]');
			if (rotationFactorMinus && rotationFactorInput) {
				rotationFactorMinus.addEventListener('click', () => {
						const current = parseFloat(rotationFactorInput.value || '0') || 0;
						const next = current + (current * -0.9);
						rotationFactorInput.value = String(next);
						applyControlsRuntimeEffects();
					});
				}
				if (rotationFactorPlus && rotationFactorInput) {
					rotationFactorPlus.addEventListener('click', () => {
						const current = parseFloat(rotationFactorInput.value || '0') || 0;
						const next = current + (current * 0.9);
						rotationFactorInput.value = String(next);
						applyControlsRuntimeEffects();
					});
				}
				document.querySelectorAll('.tp3businessview-controls.tp3-panel [name^="settings["]').forEach((field) => {
					field.addEventListener('change', () => {
						applyControlsRuntimeEffects();
					});
				});
				applyControlsRuntimeEffects();

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

			document.addEventListener('click', (event) => {
				const button = event.target.closest('.actions-view');
				if (!button) return;

				const type = button.getAttribute('data-view-type');
				const uid = button.getAttribute('data-bv-uid');
				if (!uid) return;

				const businessViewUid = parseInt(button.getAttribute('data-businessview-uid') || '0', 10) || 0;
				loadBusinessView(uid, type, { businessViewUid });
			});

			document.addEventListener('click', function (event) {
				const button = event.target.closest('.pano-sort');
				if (!button) return;

				event.preventDefault();
				sortPanorama(button);
			});

			window.addEventListener('beforeunload', (event) => {
				clearTourTimers();
				if (!this.editorState.isDirty) {
					return;
				}
				event.preventDefault();
				event.returnValue = '';
			});

			const firstPanoButton = document.querySelector('.actions-view.pano[data-bv-uid]');
			if (firstPanoButton) {
				const firstUid = firstPanoButton.getAttribute('data-bv-uid');
				const firstBusinessViewUid = parseInt(firstPanoButton.getAttribute('data-businessview-uid') || '0', 10) || 0;
				if (firstUid) {
					loadBusinessView(firstUid, 'pano', { businessViewUid: firstBusinessViewUid });
					this.updateStatus('Panorama wird geladen …', 'info');
					return;
				}
			}

			if (!this.editorState.selectedPanoramaPid && defaultPid > 0) {
				this.editorState.selectedPanoramaPid = defaultPid;
			}
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

		const panoramaOptions = {
			position: data.location.latLng,
			pano: data.location.pano,
			pov: this.pov,
			zoom: this.pov.zoom,
			visible: true,
			motionTracking: true,
			motionTrackingControl: true,
		};
		const pano = this.panorama || new google.maps.StreetViewPanorama(panoCanvas, panoramaOptions);

		if (this.panorama) {
			pano.setOptions({
				pov: this.pov,
				zoom: this.pov.zoom,
				visible: true,
				motionTracking: true,
				motionTrackingControl: true,
			});
			pano.setPosition(data.location.latLng);
			pano.setPano(data.location.pano);
		}

		if (!this._panoramaPanelEventsBound) {
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
			this._panoramaPanelEventsBound = true;
		}

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
		if (!this._panoramaEventsBound) {
			this.bindPanoramaEvents();
			this._panoramaEventsBound = true;
		}
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

	syncPanoramaPanel(pano, markDirty = true) {
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
		const patch = {
			panoId: pano.getPano() || '',
		};

		if (positionCell && position) {
			positionCell.value = position.toString();
			patch.position = position.toString();
		}

		if (headingCell && pov) {
			headingCell.value = pov.heading;
			patch.heading = pov.heading;
		}

		if (pitchCell && pov) {
			pitchCell.value = pov.pitch;
			patch.pitch = pov.pitch;
		}

		if (zoomCell) {
			zoomCell.value = pano.getZoom();
			patch.zoom = pano.getZoom();
		}

		if (panoCell) {
			panoCell.value = patch.panoId;
		}

		if (position) {
			this.BusinessAdress = position;
		}
		if (pov) {
			this.pov = {
				heading: pov.heading,
				pitch: pov.pitch,
				zoom: pano.getZoom(),
			};
		}

		this.updateDraft(patch, markDirty);
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

		this.panorama.addListener('pano_changed', () => {
			this.syncPanoramaPanel(this.panorama);
		});

		this.syncPanoramaPanel(this.panorama, false);
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

	_isInitializing: false,
	_isInitialized: false,
	_panoRotationIntervalId: null,
	_panoJumpIntervalId: null,
	geocoder: null,
	infowindow: null,
	editorState: {
		selectedBusinessViewUid: 0,
		selectedPanoramaUid: 0,
		selectedPanoramaPid: 0,
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

export default Tp3App;

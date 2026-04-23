class Tp3Json {
    constructor(rootElement) {
        this.rootElement = rootElement;
        this.jsonUrl = rootElement?.dataset?.jsonUrl || '';
		this.pid = rootElement?.dataset?.pid || '';
		this.businessview = rootElement?.dataset?.bvUid || '';
    }

    async init() {
        if (!this.rootElement || !this.jsonUrl) {
            return;
        }

        try {
            const url = new URL(this.jsonUrl, window.location.origin);
            if (this.pid) {
                url.searchParams.set('pid', this.pid);
            }
			if (this.businessview) {
				url.searchParams.set('businessview', this.businessview);
			}

            const response = await fetch(url.toString(), {
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
            this.publish(data);
        } catch (error) {
            console.error('Tp3Json JSON load failed:', error);
            this.publishError(error);
        }
    }

    publish(data) {
        if (!data || typeof data !== 'object') {
            return;
        }

        const currentJson = window.businessviewJson && typeof window.businessviewJson === 'object'
            ? window.businessviewJson
            : {};
        const mergedJson = Object.assign({}, currentJson, data);
        const currentSettings = currentJson.settings && typeof currentJson.settings === 'object' && !Array.isArray(currentJson.settings)
            ? currentJson.settings
            : {};
        const incomingSettings = data.settings && typeof data.settings === 'object' && !Array.isArray(data.settings)
            ? data.settings
            : {};
        const hasIncomingSettings = Object.keys(incomingSettings).length > 0;
        mergedJson.settings = hasIncomingSettings
            ? Object.assign({}, currentSettings, incomingSettings)
            : currentSettings;
        window.businessviewJson = mergedJson;

        document.dispatchEvent(new CustomEvent('tp3businessview:json-ready', {
            detail: data,
        }));

        if (this.rootElement?.dataset?.debugJson === '1') {
            this.rootElement.innerHTML = `<pre>${this.escapeHtml(JSON.stringify(data, null, 2))}</pre>`;
        }
    }

    publishError(error) {
        document.dispatchEvent(new CustomEvent('tp3businessview:json-error', {
            detail: error,
        }));

        if (this.rootElement?.dataset?.debugJson === '1') {
            this.rootElement.innerHTML = '<p>Die Daten konnten nicht geladen werden.</p>';
        }
    }

    escapeHtml(value) {
        return String(value)
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }
}

function boot() {
    const rootElement = document.querySelector('#tp3-businessview-app');
    if (!rootElement) {
        return;
    }

    const app = new Tp3Json(rootElement);
    app.init();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
} else {
    boot();
}

export default Tp3Json;
export { boot };

class Tp3Json {
    constructor(rootElement) {
        this.rootElement = rootElement;
        this.jsonUrl = rootElement?.dataset?.jsonUrl || '';
        this.pid = rootElement?.dataset?.pid || '';
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
            this.render(data);
        } catch (error) {
            console.error('Tp3Json JSON load failed:', error);
            this.rootElement.innerHTML = '<p>Die Daten konnten nicht geladen werden.</p>';
        }
    }

    render(data) {
        this.rootElement.innerHTML = `
            <pre>${this.escapeHtml(JSON.stringify(data, null, 2))}</pre>
        `;
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

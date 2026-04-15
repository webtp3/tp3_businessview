import Tp3App from './Tp3App.js';

function boot() {
    const rootElement = document.querySelector('#tp3-businessview-app');
    if (!rootElement) {
        return;
    }

    const jsonUrl = rootElement.dataset.jsonUrl || '';
    if (jsonUrl) {
        window.tp3BusinessViewJsonUrl = jsonUrl;
    }

    Tp3App.init();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
} else {
    boot();
}

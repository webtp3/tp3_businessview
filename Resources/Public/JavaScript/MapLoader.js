let googleMapsLoaderPromise = null;

export function loadGoogleMaps(apiKey) {
  if (window.google && window.google.maps) {
    return Promise.resolve(window.google);
  }

  if (googleMapsLoaderPromise) {
    return googleMapsLoaderPromise;
  }

  googleMapsLoaderPromise = new Promise((resolve, reject) => {
    const script = document.createElement('script');
    const key = encodeURIComponent(apiKey || '');

    script.src = `https://maps.googleapis.com/maps/api/js?key=${key}&libraries=places`;
    script.async = true;
    script.defer = true;

    script.onload = () => {
      if (window.google && window.google.maps) {
        resolve(window.google);
      } else {
        reject(new Error('Google Maps API loaded, but window.google.maps is missing.'));
      }
    };

    script.onerror = () => {
      reject(new Error('Failed to load Google Maps API.'));
    };

    document.head.appendChild(script);
  });

  return googleMapsLoaderPromise;
}

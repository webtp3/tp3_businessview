export function initGallery({ $, window, document }) {
  function appendGalleryToBusinessview(photos) {
    const canvas = '#businessview-canvas';

    if (!photos || !photos.length) {
      return;
    }

    if ($(canvas).find('#businessview-gallery-canvas').length === 0) {
      $(canvas).append('<ul id="businessview-gallery-canvas"></ul>');
    }

    for (let i = 0; i < photos.length; i++) {
      const renditions = photos[i].renditions || {};
      const largeUrl = renditions.large ? renditions.large.url : '';
      const smallUrl = renditions.small ? renditions.small.url : '';

      $(canvas + ' ul#businessview-gallery-canvas').append(
        '<li><a href="' +
          largeUrl +
          '" data-fancybox-group="businessview-gallery"><img src="' +
          smallUrl +
          '" alt=""></a></li>'
      );
    }
  }

  function appendPhotoToGallery(photo) {
    if (!photo || !photo.renditions) {
      return;
    }

    const renditions = photo.renditions;
    const largeUrl = renditions.large ? renditions.large.url : '';
    const smallUrl = renditions.small ? renditions.small.url : '';

    $('#businessview-canvas ul#businessview-gallery-canvas').append(
      '<li><a href="' +
        largeUrl +
        '" data-fancybox-group="businessview-gallery"><img src="' +
        smallUrl +
        '" alt=""></a></li>'
    );
  }

  window.Tp3Gallery = {
    appendGalleryToBusinessview,
    appendPhotoToGallery,
  };
}

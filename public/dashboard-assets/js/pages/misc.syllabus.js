/**
 *
 * MiscSyllabus
 *
 * Misc.Player page content scripts. Initialized from scripts.js file.
 *
 *
 */

class MiscSyllabus {
  constructor() {
    // Initialization of the page plugins
    if (typeof baguetteBox !== 'undefined') {
      this._initLightboxes();
    } else {
      console.error('[CS] baguetteBox is undefined.');
    }
  }

  // Lightboxes initialize
  _initLightboxes() {
    baguetteBox.run('.lightbox');
  }
}

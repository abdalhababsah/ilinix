/**
 *
 * PathList
 *
 * Path.List page content scripts. Initialized from scripts.js file.
 *
 *
 */

class PathList {
  constructor() {
    this._initProgress();
  }

  _initProgress() {
    document.querySelectorAll('.progress-bar').forEach((element) => {
      const volume = element.getAttribute('aria-valuenow');
      element.style.width = volume + '%';
    });
  }
}

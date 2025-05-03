/**
 *
 * CourseDetail
 *
 * Course.Detail page content scripts. Initialized from scripts.js file.
 *
 *
 */

class CourseDetail {
  constructor() {
    this._initPlayer();
    this._initBarrating();
    this._initProgressBars();
  }

  _initPlayer() {
    if (document.querySelector('#videoPlayer') !== null && typeof Plyr !== 'undefined') {
      new Plyr(document.querySelector('#videoPlayer'));
    }
  }

  _initProgressBars() {
    document.querySelectorAll('.progress-bar').forEach((element) => {
      const volume = element.getAttribute('aria-valuenow');
      element.style.width = volume + '%';
    });
  }

  _initBarrating() {
    if (jQuery().barrating) {
      jQuery('.rating').each(function () {
        const current = jQuery(this).data('initialRating');
        const readonly = jQuery(this).data('readonly');
        const showSelectedRating = jQuery(this).data('showSelectedRating');
        const showValues = jQuery(this).data('showValues');
        jQuery(this).barrating({
          initialRating: current,
          readonly: readonly,
          showValues: showValues,
          showSelectedRating: showSelectedRating,
          onSelect: function (value, text) {},
          onClear: function (value, text) {},
        });
      });
    }
  }
}

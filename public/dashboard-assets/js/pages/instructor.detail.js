/**
 *
 * InstructorDetail
 *
 * Instructor.Detail page content scripts. Initialized from scripts.js file.
 *
 *
 */

class InstructorDetail {
  constructor() {
    this._initBarrating();
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

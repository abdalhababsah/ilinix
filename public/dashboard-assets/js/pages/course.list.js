/**
 *
 * CourseList
 *
 * Course.List page content scripts. Initialized from scripts.js file.
 *
 *
 */

class CourseList {
  constructor() {
    this.menuButton = document.getElementById('menuButton');
    this.menuModal = new bootstrap.Modal(document.getElementById('menuModal'));

    this._addListeners();
    this._initMenuMoveContent();
    this._initBarrating();
  }

  _addListeners() {
    this.menuButton && this.menuButton.addEventListener('click', this._showMenuModal.bind(this));
  }

  _initMenuMoveContent() {
    const _this = this;
    if (document.querySelector('#menuMoveContent')) {
      const menuMove = document.querySelector('#menuMoveContent');
      const targetSelectorMenu = menuMove.getAttribute('data-move-target');
      const moveBreakpointMenu = menuMove.getAttribute('data-move-breakpoint');
      const menuMoveContent = new MoveContent(menuMove, {
        targetSelector: targetSelectorMenu,
        moveBreakpoint: moveBreakpointMenu,
        afterMove: (placement) => {
          _this._initBarratingForFilters();
        },
      });
    }
  }

  _hideMenuModal() {
    this.menuModal.hide();
  }

  _showMenuModal() {
    this.menuModal.show();
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

  _initBarratingForFilters() {
    if (jQuery().barrating) {
      jQuery('.rating-filter').each(function () {
        var current = jQuery(this).data('initialRating');
        var readonly = jQuery(this).data('readonly');
        var showSelectedRating = jQuery(this).data('showSelectedRating');
        var showValues = jQuery(this).data('showValues');
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

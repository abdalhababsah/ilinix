/**
 *
 * MiscPlayer
 *
 * Misc.Player page content scripts. Initialized from scripts.js file.
 *
 *
 */

class MiscPlayer {
  constructor() {
    this._contentsScrollbar = null;
    this._initPlayer();
    this._initMoveContent();
  }

  _initPlayer() {
    document.querySelectorAll('.player').forEach((el) => {
      new Plyr(el);
    });
  }

  _initMoveContent() {
    if (typeof MoveContent !== 'undefined') {
      if (document.querySelector('#tableOfContentsMoveContent')) {
        const filterMove = document.querySelector('#tableOfContentsMoveContent');
        const targetSelectorFilter = filterMove.getAttribute('data-move-target');
        const moveBreakpointFilter = filterMove.getAttribute('data-move-breakpoint');
        const filterMoveContent = new MoveContent(filterMove, {
          targetSelector: targetSelectorFilter,
          moveBreakpoint: moveBreakpointFilter,
          beforeMove: (placement) => {
            // Called before clearing of the html and moving content. Good for destroying plugins.
            if (this._contentsScrollbar) {
              this._contentsScrollbar.destroy();
            }
          },
          afterMove: (placement) => {
            // Called after clearing of the html and moving content. Good for initializing plugins.
            if (typeof OverlayScrollbars !== 'undefined') {
              this._contentsScrollbar = OverlayScrollbars(document.querySelectorAll('.table-of-contents-scroll'), {
                scrollbars: {},
                overflowBehavior: {x: 'hidden', y: 'scroll'},
              });
            }
            jQuery('#tableOfContentsModal').modal('hide');
          },
        });
      }
    }
  }
}

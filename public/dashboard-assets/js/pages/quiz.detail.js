/**
 *
 * QuizDetail
 *
 * Quiz.Detail page content scripts. Initialized from scripts.js file.
 *
 *
 */

class QuizDetail {
  constructor() {
    this._initTimer();
  }

  _initTimer() {
    if (typeof Countdown !== 'undefined') {
      var dateToCount = new Date(new Date().setMinutes(new Date().getMinutes() + 15));
      var countdown = new Countdown({
        selector: '#timer',
        leadingZeros: true,
        msgBefore: '',
        msgAfter: '',
        msgPattern: `
                      <div class="row gx-5">
                          <div class="col-auto">
                              <div class="display-5 text-primary mb-1">{minutes}</div>
                              <div>Minutes</div>
                          </div>
                          <div class="col-auto">
                              <div class="display-5 text-primary mb-1">{seconds}</div>
                              <div>Seconds</div>
                          </div>
                      </div>`,
        dateEnd: dateToCount,
      });
    }
  }
}

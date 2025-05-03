/**
 *
 * ElearningDashboard
 *
 * Dashboards.Elearning page content scripts. Initialized from scripts.js file.
 *
 *
 */

class ElearningDashboard {
  constructor() {
    this._timeChart = null;

    this._initProgressBars();
    this._initAchievementsCarousel();
    this._initTimeChart();
    this._initEvents();
    this._initBarrating();
  }

  _initEvents() {
    // Listening for color change events to update charts
    document.documentElement.addEventListener(Globals.colorAttributeChange, (event) => {
      this._timeChart && this._timeChart.destroy();
      this._initTimeChart();
    });
  }

  _initProgressBars() {
    document.querySelectorAll('.progress-bar').forEach((element) => {
      const volume = element.getAttribute('aria-valuenow');
      element.style.width = volume + '%';
    });
  }

  _initAchievementsCarousel() {
    if (document.querySelector('#glideAchievements')) {
      new GlideCustom(
        document.querySelector('#glideAchievements'),
        {
          gap: 0,
          rewind: false,
          bound: true,
          // type: 'carousel',
          // autoplay: 4000,
          perView: 6,
          breakpoints: {
            600: {perView: 1},
            1400: {perView: 2},
            1900: {perView: 4},
            3840: {perView: 5},
          },
        },
        true,
      ).mount();
    }
  }

  _initTimeChart() {
    if (document.getElementById('timeChart')) {
      var ctx = document.getElementById('timeChart').getContext('2d');
      this._timeChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          datasets: [
            {
              label: '',
              data: [450, 475, 625],
              backgroundColor: ['rgba(' + Globals.primaryrgb + ',0.1)', 'rgba(' + Globals.secondaryrgb + ',0.1)', 'rgba(' + Globals.quaternaryrgb + ',0.1)'],
              borderColor: [Globals.primary, Globals.secondary, Globals.quaternary],
            },
          ],
          labels: ['Breads', 'Cakes', 'Sandwich'],
          icons: ['loaf', 'cupcake', 'burger'],
        },
        options: {
          plugins: {
            datalabels: {display: false},
          },
          cutoutPercentage: 70,
          responsive: true,
          maintainAspectRatio: false,
          title: {
            display: false,
          },
          layout: {
            padding: {
              bottom: 20,
            },
          },
          legend: {
            position: 'bottom',
            labels: ChartsExtend.LegendLabels(),
          },
          tooltips: {
            enabled: false,
            custom: function (tooltip) {
              var tooltipEl = this._chart.canvas.parentElement.querySelector('.custom-tooltip');
              if (tooltip.opacity === 0) {
                tooltipEl.style.opacity = 0;
                return;
              }
              tooltipEl.classList.remove('above', 'below', 'no-transform');
              if (tooltip.yAlign) {
                tooltipEl.classList.add(tooltip.yAlign);
              } else {
                tooltipEl.classList.add('no-transform');
              }
              if (tooltip.body) {
                var chart = this;
                var index = tooltip.dataPoints[0].index;
                var icon = tooltipEl.querySelector('.icon');
                icon.style = 'color: ' + tooltip.labelColors[0].borderColor;
                icon.setAttribute('data-acorn-icon', chart._data.icons[index]);
                new AcornIcons().replace();
                var iconContainer = tooltipEl.querySelector('.icon-container');
                iconContainer.style = 'border-color: ' + tooltip.labelColors[0].borderColor + '!important';
                tooltipEl.querySelector('.text').innerHTML = chart._data.labels[index].toLocaleUpperCase();
                tooltipEl.querySelector('.value').innerHTML = chart._data.datasets[0].data[index];
              }
              var positionY = this._chart.canvas.offsetTop;
              var positionX = this._chart.canvas.offsetLeft;
              tooltipEl.style.opacity = 1;
              tooltipEl.style.left = positionX + tooltip.caretX + 'px';
              tooltipEl.style.top = positionY + tooltip.caretY + 'px';
            },
          },
        },
      });
    }
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

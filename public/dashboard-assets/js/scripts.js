/**
 *
 * Scripts
 *
 * Initialization of the template base and page scripts.
 *
 *
 */

class Scripts {
  constructor() {
    this._initSettings();
    this._initVariables();
    this._addListeners();
    this._init();
  }

  // Showing the template after waiting for a bit so that the css variables are all set
  // Initialization of the common scripts and page specific ones
  _init() {
    setTimeout(() => {
      document.documentElement.setAttribute('data-show', 'true');
      document.body.classList.remove('spinner');
      this._initBase();
      this._initCommon();
      this._initPages();
    }, 100);
  }

  // Base scripts initialization
  _initBase() {
    // Navigation
    if (typeof Nav !== 'undefined') {
      const nav = new Nav(document.getElementById('nav'));
    }

    // Search implementation
    if (typeof Search !== 'undefined') {
      const search = new Search();
    }

    // AcornIcons initialization
    if (typeof AcornIcons !== 'undefined') {
      new AcornIcons().replace();
    }
  }

  // Common plugins and overrides initialization
  _initCommon() {
    // common.js initialization
    if (typeof Common !== 'undefined') {
      let common = new Common();
    }
  }

  // Page scripts initialization
  _initPages() {
    // dashboard.elearning.js initialization
    if (typeof ElearningDashboard !== 'undefined') {
      const elearningDashboard = new ElearningDashboard();
    }

    // dashboard.school.js initialization
    if (typeof SchoolDashboard !== 'undefined') {
      const schoolDashboard = new SchoolDashboard();
    }

    // course.detail.js initialization
    if (typeof CourseDetail !== 'undefined') {
      const courseDetail = new CourseDetail();
    }

    // course.list.js initialization
    if (typeof CourseList !== 'undefined') {
      const courseList = new CourseList();
    }

    // course.explore.js initialization
    if (typeof CourseExplore !== 'undefined') {
      const courseExplore = new CourseExplore();
    }

    // instructor.list.js initialization
    if (typeof InstructorList !== 'undefined') {
      const instructorList = new InstructorList();
    }

    // instructor.detail.js initialization
    if (typeof InstructorDetail !== 'undefined') {
      const instructorDetail = new InstructorDetail();
    }

    // quiz.detail.js initialization
    if (typeof QuizDetail !== 'undefined') {
      const quizDetail = new QuizDetail();
    }

    // path.list.js initialization
    if (typeof PathList !== 'undefined') {
      const pathList = new PathList();
    }

    // path.detail.js initialization
    if (typeof PathDetail !== 'undefined') {
      const pathDetail = new PathDetail();
    }

    // misc.player.js initialization
    if (typeof MiscPlayer !== 'undefined') {
      const miscPlayer = new MiscPlayer();
    }

    // misc.syllabus.js initialization
    if (typeof MiscSyllabus !== 'undefined') {
      const miscSyllabus = new MiscSyllabus();
    }
  }

  // Settings initialization
  _initSettings() {
    if (typeof Settings !== 'undefined') {
      const settings = new Settings({
        attributes: {placement: 'vertical', layout: 'boxed', behaviour: 'unpinned', color: 'light-green'},
        showSettings: true,
        storagePrefix: 'acorn-elearning-portal-',
      });
    }
  }

  // Variables initialization of Globals.js file which contains valus from css
  _initVariables() {
    if (typeof Variables !== 'undefined') {
      const variables = new Variables();
    }
  }

  // Listeners of menu and layout changes which fires a resize event
  _addListeners() {
    document.documentElement.addEventListener(Globals.menuPlacementChange, (event) => {
      setTimeout(() => {
        window.dispatchEvent(new Event('resize'));
      }, 25);
    });

    document.documentElement.addEventListener(Globals.layoutChange, (event) => {
      setTimeout(() => {
        window.dispatchEvent(new Event('resize'));
      }, 25);
    });

    document.documentElement.addEventListener(Globals.menuBehaviourChange, (event) => {
      setTimeout(() => {
        window.dispatchEvent(new Event('resize'));
      }, 25);
    });
  }
}

// Shows the template after initialization of the settings, nav, variables and common plugins.
(function () {
  window.addEventListener('DOMContentLoaded', () => {
    // Initializing of the Scripts
    if (typeof Scripts !== 'undefined') {
      const scripts = new Scripts();
    }
  });
})();

// Disabling dropzone auto discover before DOMContentLoaded
(function () {
  if (typeof Dropzone !== 'undefined') {
    Dropzone.autoDiscover = false;
  }
})();

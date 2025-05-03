<div id="nav" class="nav-container d-flex">
    <div class="nav-content d-flex">
      <!-- Logo Start -->
      <div class="logo position-relative">
        <a href="index.html">
          <!-- Logo can be added directly -->
          <!-- <img src="img/logo/logo-white.svg" alt="logo" /> -->

          <!-- Or added via css to provide different ones for different color themes -->
          <div class="img"></div>
        </a>
      </div>
      <!-- Logo End -->

      <!-- Language Switch Start -->
      <div class="language-switch-container">
        <button class="btn btn-empty language-button dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">EN</button>
        <div class="dropdown-menu">
          <a href="#" class="dropdown-item">DE</a>
          <a href="#" class="dropdown-item active">EN</a>
          <a href="#" class="dropdown-item">ES</a>
        </div>
      </div>
      <!-- Language Switch End -->

      <!-- User Menu Start -->
      <div class="user-container d-flex">
        <a href="#" class="d-flex user position-relative" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img class="profile" alt="profile" src="img/profile/profile-3.webp" />
          <div class="name">Lisa Jackson</div>
        </a>
        <div class="dropdown-menu dropdown-menu-end user-menu wide">
          <div class="row mb-3 ms-0 me-0">
            <div class="col-12 ps-1 mb-2">
              <div class="text-extra-small text-primary">ACCOUNT</div>
            </div>
            <div class="col-6 ps-1 pe-1">
              <ul class="list-unstyled">
                <li>
                  <a href="#">User Info</a>
                </li>
                <li>
                  <a href="#">Preferences</a>
                </li>
                <li>
                  <a href="#">Calendar</a>
                </li>
              </ul>
            </div>
            <div class="col-6 pe-1 ps-1">
              <ul class="list-unstyled">
                <li>
                  <a href="#">Security</a>
                </li>
                <li>
                  <a href="#">Billing</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="row mb-1 ms-0 me-0">
            <div class="col-12 p-1 mb-2 pt-2">
              <div class="text-extra-small text-primary">APPLICATION</div>
            </div>
            <div class="col-6 ps-1 pe-1">
              <ul class="list-unstyled">
                <li>
                  <a href="#">Themes</a>
                </li>
                <li>
                  <a href="#">Language</a>
                </li>
              </ul>
            </div>
            <div class="col-6 pe-1 ps-1">
              <ul class="list-unstyled">
                <li>
                  <a href="#">Devices</a>
                </li>
                <li>
                  <a href="#">Storage</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="row mb-1 ms-0 me-0">
            <div class="col-12 p-1 mb-3 pt-3">
              <div class="separator-light"></div>
            </div>
            <div class="col-6 ps-1 pe-1">
              <ul class="list-unstyled">
                <li>
                  <a href="#">
                    <i data-acorn-icon="help" class="me-2" data-acorn-size="17"></i>
                    <span class="align-middle">Help</span>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i data-acorn-icon="file-text" class="me-2" data-acorn-size="17"></i>
                    <span class="align-middle">Docs</span>
                  </a>
                </li>
              </ul>
            </div>
            <div class="col-6 pe-1 ps-1">
              <ul class="list-unstyled">
                <li>
                  <a href="#">
                    <i data-acorn-icon="gear" class="me-2" data-acorn-size="17"></i>
                    <span class="align-middle">Settings</span>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i data-acorn-icon="logout" class="me-2" data-acorn-size="17"></i>
                    <span class="align-middle">Logout</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- User Menu End -->

      <!-- Icons Menu Start -->
      <ul class="list-unstyled list-inline text-center menu-icons">
        <li class="list-inline-item">
          <a href="#" data-bs-toggle="modal" data-bs-target="#searchPagesModal">
            <i data-acorn-icon="search" data-acorn-size="18"></i>
          </a>
        </li>
        <li class="list-inline-item">
          <a href="#" id="pinButton" class="pin-button">
            <i data-acorn-icon="lock-on" class="unpin" data-acorn-size="18"></i>
            <i data-acorn-icon="lock-off" class="pin" data-acorn-size="18"></i>
          </a>
        </li>
        <li class="list-inline-item">
          <a href="#" id="colorButton">
            <i data-acorn-icon="light-on" class="light" data-acorn-size="18"></i>
            <i data-acorn-icon="light-off" class="dark" data-acorn-size="18"></i>
          </a>
        </li>
        <li class="list-inline-item">
          <a href="#" data-bs-toggle="dropdown" data-bs-target="#notifications" aria-haspopup="true" aria-expanded="false" class="notification-button">
            <div class="position-relative d-inline-flex">
              <i data-acorn-icon="bell" data-acorn-size="18"></i>
              <span class="position-absolute notification-dot rounded-xl"></span>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-end wide notification-dropdown scroll-out" id="notifications">
            <div class="scroll">
              <ul class="list-unstyled border-last-none">
                <li class="mb-3 pb-3 border-bottom border-separator-light d-flex">
                  <img src="img/profile/profile-1.webp" class="me-3 sw-4 sh-4 rounded-xl align-self-center" alt="..." />
                  <div class="align-self-center">
                    <a href="#">Joisse Kaycee just sent a new comment!</a>
                  </div>
                </li>
                <li class="mb-3 pb-3 border-bottom border-separator-light d-flex">
                  <img src="img/profile/profile-2.webp" class="me-3 sw-4 sh-4 rounded-xl align-self-center" alt="..." />
                  <div class="align-self-center">
                    <a href="#">New order received! It is total $147,20.</a>
                  </div>
                </li>
                <li class="mb-3 pb-3 border-bottom border-separator-light d-flex">
                  <img src="img/profile/profile-3.webp" class="me-3 sw-4 sh-4 rounded-xl align-self-center" alt="..." />
                  <div class="align-self-center">
                    <a href="#">3 items just added to wish list by a user!</a>
                  </div>
                </li>
                <li class="pb-3 pb-3 border-bottom border-separator-light d-flex">
                  <img src="img/profile/profile-6.webp" class="me-3 sw-4 sh-4 rounded-xl align-self-center" alt="..." />
                  <div class="align-self-center">
                    <a href="#">Kirby Peters just sent a new message!</a>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </li>
      </ul>
      <!-- Icons Menu End -->

      <!-- Menu Start -->
      <div class="menu-container flex-grow-1">
        <ul id="menu" class="menu">
          <li>
            <a href="#dashboards">
              <i data-acorn-icon="home-garage" class="icon" data-acorn-size="18"></i>
              <span class="label">Dashboards</span>
            </a>
            <ul id="dashboards">
              <li>
                <a href="Dashboards.Elearning.html">
                  <span class="label">Elearning</span>
                </a>
              </li>
              <li>
                <a href="Dashboards.School.html">
                  <span class="label">School</span>
                </a>
              </li>
            </ul>
          </li>
          <li>
            <a href="#courses">
              <i data-acorn-icon="online-class" class="icon" data-acorn-size="18"></i>
              <span class="label">Courses</span>
            </a>
            <ul id="courses">
              <li>
                <a href="Course.Explore.html">
                  <span class="label">Explore</span>
                </a>
              </li>
              <li>
                <a href="Course.List.html">
                  <span class="label">List</span>
                </a>
              </li>
              <li>
                <a href="Course.Detail.html">
                  <span class="label">Detail</span>
                </a>
              </li>
            </ul>
          </li>
          <li>
            <a href="#quiz">
              <i data-acorn-icon="quiz" class="icon" data-acorn-size="18"></i>
              <span class="label">Quiz</span>
            </a>
            <ul id="quiz">
              <li>
                <a href="Quiz.List.html">
                  <span class="label">List</span>
                </a>
              </li>
              <li>
                <a href="Quiz.Detail.html">
                  <span class="label">Detail</span>
                </a>
              </li>
              <li>
                <a href="Quiz.Result.html">
                  <span class="label">Result</span>
                </a>
              </li>
            </ul>
          </li>
          <li>
            <a href="#paths">
              <i data-acorn-icon="destination" class="icon" data-acorn-size="18"></i>
              <span class="label">Paths</span>
            </a>
            <ul id="paths">
              <li>
                <a href="Path.List.html">
                  <span class="label">List</span>
                </a>
              </li>
              <li>
                <a href="Path.Detail.html">
                  <span class="label">Detail</span>
                </a>
              </li>
            </ul>
          </li>
          <li>
            <a href="#instructors">
              <i data-acorn-icon="lecture" class="icon" data-acorn-size="18"></i>
              <span class="label">Instructors</span>
            </a>
            <ul id="instructors">
              <li>
                <a href="Instructor.List.html">
                  <span class="label">List</span>
                </a>
              </li>
              <li>
                <a href="Instructor.Detail.html">
                  <span class="label">Detail</span>
                </a>
              </li>
            </ul>
          </li>
          <li>
            <a href="#miscellaneous">
              <i data-acorn-icon="layout-5" class="icon" data-acorn-size="18"></i>
              <span class="label">Miscellaneous</span>
            </a>
            <ul id="miscellaneous">
              <li>
                <a href="Misc.Player.html">
                  <span class="label">Player</span>
                </a>
              </li>
              <li>
                <a href="Misc.Material.html">
                  <span class="label">Material</span>
                </a>
              </li>
              <li>
                <a href="Misc.Syllabus.html">
                  <span class="label">Syllabus</span>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
      <!-- Menu End -->

      <!-- Mobile Buttons Start -->
      <div class="mobile-buttons-container">
        <!-- Scrollspy Mobile Button Start -->
        <a href="#" id="scrollSpyButton" class="spy-button" data-bs-toggle="dropdown">
          <i data-acorn-icon="menu-dropdown"></i>
        </a>
        <!-- Scrollspy Mobile Button End -->

        <!-- Scrollspy Mobile Dropdown Start -->
        <div class="dropdown-menu dropdown-menu-end" id="scrollSpyDropdown"></div>
        <!-- Scrollspy Mobile Dropdown End -->

        <!-- Menu Button Start -->
        <a href="#" id="mobileMenuButton" class="menu-button">
          <i data-acorn-icon="menu"></i>
        </a>
        <!-- Menu Button End -->
      </div>
      <!-- Mobile Buttons End -->
    </div>
    <div class="nav-shadow"></div>
  </div>
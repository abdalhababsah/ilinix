<div id="nav" class="nav-container d-flex">
    <div class="nav-content d-flex">
        <!-- Logo Start -->
        <div class="logo position-relative">
            <a href="{{ route('dashboard') }}" >
                <!-- Logo can be added directly -->
                <img src="{{ asset('dashboard-assets/img/logo/logo-white.svg') }}" alt="logo" />

                <!-- Or added via css to provide different ones for different color themes -->
                {{-- <div class="img"></div> --}}
            </a>
        </div>
        <!-- Logo End -->

        <!-- Language Switch Start -->
        {{-- <div class="language-switch-container">
            <button class="btn btn-empty text-primary language-button dropdown-toggle" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">EN</button>
            <div class="dropdown-menu">
                <a href="#" class="dropdown-item">DE</a>
                <a href="#" class="dropdown-item active">EN</a>
                <a href="#" class="dropdown-item">ES</a>
            </div>
        </div> --}}
        <!-- Language Switch End -->

        <!-- User Menu Start -->
        <div class="user-container d-flex">
            <a href="#" class="d-flex user position-relative" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="text-white profile" data-acorn-icon="user" data-acorn-size="18"></i>
                <div class="name">
                    {{ Auth::user()->first_name ?? 'Unknown' }} {{ Auth::user()->last_name ?? 'Name' }}
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end user-menu wide">
                <div class="row mb-1 ms-0 me-0">
                    <div class="col-12 p-1 mb-2 pt-2">
                        <div class="text-extra-small text-primary">ACCOUNT</div>
                    </div>
                    <div class="col-12 ps-1 pe-1">
                        <div class="card">
                            <div >
                                <div class="mb-2">
                                    <strong>{{ Auth::user()->first_name ?? 'Unknown' }} {{ Auth::user()->last_name ?? 'Name' }}</strong>
                                </div>
                                <div class="mb-2">
                                    <i data-acorn-icon="email" class="me-1" data-acorn-size="15"></i>
                                    <span>{{ Auth::user()->email ?? 'No email available' }}</span>
                                </div>
                                <div>
                                    <i data-acorn-icon="user" class="me-1" data-acorn-size="15"></i>
                                    <span>Role: {{ Auth::user()->role_id == 1 ? 'admin' : (Auth::user()->role_id == 2 ? 'mentor' : (Auth::user()->role_id == 3 ? 'intern' : 'Unknown Role')) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-1 ms-0 me-0">
                    <div class="col-12 p-1 mb-3 pt-3">
                        <div class="separator-light"></div>
                    </div>
                    <div class="col-12 pe-1 ps-1">
                        <ul class="list-unstyled">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-link dropdown-item">
                                        <i data-acorn-icon="logout" class="me-2" data-acorn-size="17"></i>
                                        <span class="align-middle">Logout</span>
                                    </button>
                                </form>
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
    
        </ul>
        <!-- Icons Menu End -->

        <!-- Menu Start -->
        <div class="menu-container flex-grow-1">
            <ul id="menu" class="menu">
                <li class="{{ request()->routeIs('dashboard', 'intern.dashboard', 'admin.dashboard', 'mentor.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <i data-acorn-icon="home-garage" class="icon" data-acorn-size="18"></i>
                        <span class="label">Dashboards</span>
                    </a>
                </li>
                @if (Auth::user()->role_id == 1)
                    <li class="{{ request()->routeIs('admin.interns.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.interns.index') }}">
                            <i data-acorn-icon="online-class" class="icon" data-acorn-size="18"></i>
                            <span class="label">Interns</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('admin.admins.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.admins.index') }}">
                            <i data-acorn-icon="online-class" class="icon" data-acorn-size="18"></i>
                            <span class="label">Admins</span>
                        </a>
                    </li>
                    <li
                        class="{{ request()->routeIs('admin.certificate-programs.*') || request()->routeIs('admin.providers.index') ? 'active' : '' }}">
                        <a href="#quiz">
                            <i data-acorn-icon="quiz" class="icon" data-acorn-size="18"></i>
                            <span class="label">Certificates</span>
                        </a>
                        <ul id="quiz">
                            <li class="{{ request()->routeIs('admin.certificate-programs.index') ? 'active' : '' }}">
                                <a href="{{ route('admin.certificate-programs.index') }}">
                                    <span class="label">Certificates</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('admin.certificate-programs.create') ? 'active' : '' }}">
                                <a href="{{ route('admin.certificate-programs.create') }}">
                                    <span class="label">New Certificate</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('admin.providers.index') ? 'active' : '' }}">
                                <a href="{{ route('admin.providers.index') }}">
                                    <span class="label">Certificate Providers</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ request()->routeIs('admin.mentors.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.mentors.index') }}">
                            <i data-acorn-icon="lecture" class="icon" data-acorn-size="18"></i>
                            <span class="label">Mentors</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('admin.vouchers.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.vouchers.index') }}">
                            <i data-acorn-icon="tag" class="icon" data-acorn-size="18"></i>
                            <span class="label">Vouchers</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('admin.onboarding.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.onboarding.index') }}">
                            <i data-acorn-icon="graduation" class="icon" data-acorn-size="18"></i>
                            <span class="label">Interns Onboarding</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('chat.index') ? 'active' : '' }}">
                        <a href="{{ route('chat.index') }}">
                            <i data-acorn-icon="message" class="icon" data-acorn-size="18"></i>
                            <span class="label">Chat</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('admin.flagged-interns') ? 'active' : '' }}">
                        <a class=" text-danger" href="{{ route('admin.flagged-interns.index') }}">
                            <i data-acorn-icon="flag" class="icon  text-danger" data-acorn-size="18"></i>
                            <span class="label">Flagged Interns</span>
                        </a>
                    </li>
                @elseif (Auth::user()->role_id == 2)
                    <li class="{{ request()->routeIs('chat.index') ? 'active' : '' }}">
                        <a href="{{ route('chat.index') }}">
                            <i data-acorn-icon="message" class="icon" data-acorn-size="18"></i>
                            <span class="label">Chat</span>
                        </a>
                    </li>
                @elseif (Auth::user()->role_id == 3)

                    <li class="{{ request()->routeIs('intern.certificates.index') ? 'active' : '' }}">
                        <a href="{{ route('intern.certificates.index') }}">
                            <i data-acorn-icon="quiz" class="icon" data-acorn-size="18"></i>
                            <span class="label">Certificates</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('chat.index') ? 'active' : '' }}">
                        <a href="{{ route('chat.index') }}">
                            <i data-acorn-icon="message" class="icon" data-acorn-size="18"></i>
                            <span class="label">Chat</span>
                        </a>
                    </li>
                @endif
                
                
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
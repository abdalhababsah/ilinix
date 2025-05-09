@extends('dashboard-layout.app')

@section('content')
<div class="container">
    <!-- Title and Top Buttons Start -->
    <div class="page-title-container">
        <div class="row">
            <!-- Title Start -->
            <div class="col-12 col-md-7">
                <h1 class="mb-0 pb-0 display-4" id="title">E-learning Dashboard</h1>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
                    <ul class="breadcrumb pt-0">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="Dashboards.Elearning.html">Dashboards</a></li>
                    </ul>
                </nav>
            </div>
            <!-- Title End -->
        </div>
    </div>
    <!-- Title and Top Buttons End -->
    <!-- Content Start -->
    <div class="row">
        <!-- Continue Learning Start -->
        <div class="col-xl-6 mb-5">
            <h2 class="small-title">Continue Learning</h2>
            <div class="scroll-out">
                <div class="scroll-by-count" data-count="3">
                    <div class="card mb-2">
                        <div class="row g-0 sh-14">
                            <div class="col-auto">
                                <a href="Course.Detail.html" class="d-block position-relative h-100">
                                    <img src="img/course/small/course-1.webp" alt="alternate text"
                                        class="card-img card-img-horizontal sw-14 sw-lg-18" />
                                </a>
                            </div>
                            <div class="col">
                                <div class="card-body pt-0 pb-0 h-100 d-flex align-items-center">
                                    <div class="w-100">
                                        <div class="d-flex flex-row justify-content-between mb-2">
                                            <a href="Course.Detail.html" class="font-heading mb-1">React
                                                Web Developer Course</a>
                                            <div class="text-muted">67%</div>
                                        </div>
                                        <div class="progress mb-2">
                                            <div class="progress-bar" role="progressbar"
                                                aria-valuenow="67" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2">
                        <div class="row g-0 sh-14">
                            <div class="col-auto">
                                <a href="Course.Detail.html" class="d-block position-relative h-100">
                                    <img src="img/course/small/course-2.webp" alt="alternate text"
                                        class="card-img card-img-horizontal sw-14 sw-lg-18" />
                                </a>
                            </div>
                            <div class="col">
                                <div class="card-body pt-0 pb-0 h-100 d-flex align-items-center">
                                    <div class="w-100">
                                        <div class="d-flex flex-row justify-content-between mb-2">
                                            <a href="Course.Detail.html" class="font-heading mb-1">Python:
                                                From Zero to Expert</a>
                                            <div class="text-muted">85%</div>
                                        </div>
                                        <div class="progress mb-2">
                                            <div class="progress-bar" role="progressbar"
                                                aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2">
                        <div class="row g-0 sh-14">
                            <div class="col-auto">
                                <a href="Course.Detail.html" class="d-block position-relative h-100">
                                    <img src="img/course/small/course-3.webp" alt="alternate text"
                                        class="card-img card-img-horizontal sw-14 sw-lg-18" />
                                </a>
                            </div>
                            <div class="col">
                                <div class="card-body pt-0 pb-0 h-100 d-flex align-items-center">
                                    <div class="w-100">
                                        <div class="d-flex flex-row justify-content-between mb-2">
                                            <a href="Course.Detail.html" class="font-heading mb-1">Learn
                                                and Understand NodeJS</a>
                                            <div class="text-muted">14%</div>
                                        </div>
                                        <div class="progress mb-2">
                                            <div class="progress-bar" role="progressbar"
                                                aria-valuenow="14" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2">
                        <div class="row g-0 sh-14">
                            <div class="col-auto">
                                <a href="Course.Detail.html" class="d-block position-relative h-100">
                                    <img src="img/course/small/course-4.webp" alt="alternate text"
                                        class="card-img card-img-horizontal sw-14 sw-lg-18" />
                                </a>
                            </div>
                            <div class="col">
                                <div class="card-body pt-0 pb-0 h-100 d-flex align-items-center">
                                    <div class="w-100">
                                        <div class="d-flex flex-row justify-content-between mb-2">
                                            <a href="Course.Detail.html" class="font-heading mb-1">HTML 5
                                                - The Complete Guide</a>
                                            <div class="text-muted">63%</div>
                                        </div>
                                        <div class="progress mb-2">
                                            <div class="progress-bar" role="progressbar"
                                                aria-valuenow="63" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2">
                        <div class="row g-0 sh-14">
                            <div class="col-auto">
                                <a href="Course.Detail.html" class="d-block position-relative h-100">
                                    <img src="img/course/small/course-5.webp" alt="alternate text"
                                        class="card-img card-img-horizontal sw-14 sw-lg-18" />
                                </a>
                            </div>
                            <div class="col">
                                <div class="card-body pt-0 pb-0 h-100 d-flex align-items-center">
                                    <div class="w-100">
                                        <div class="d-flex flex-row justify-content-between mb-2">
                                            <a href="Course.Detail.html" class="font-heading mb-1">Getting
                                                Started with Gulpjs</a>
                                            <div class="text-muted">36%</div>
                                        </div>
                                        <div class="progress mb-2">
                                            <div class="progress-bar" role="progressbar"
                                                aria-valuenow="46" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Continue Learning End -->

        <!-- Recommended Courses Start -->
        <div class="col-xl-6 mb-5">
            <h2 class="small-title">Recommended for You</h2>
            <div class="card w-100 sh-50 sh-md-40 h-xl-100-card hover-img-scale-up position-relative">
                <img src="img/banner/cta-standard-3.webp" class="card-img h-100 scale position-absolute"
                    alt="card image" />
                <div class="card-img-overlay d-flex flex-column justify-content-between bg-transparent">
                    <div>
                        <div class="cta-1 mb-3 text-white w-75 w-sm-50 opacity-75">Complete Web Developer
                            Zero to Mastery</div>
                        <div class="w-50 text-white mb-3 opacity-75">
                            Liquorice caramels chupa chups bonbon. Jelly-o candy sugar chocolate cake
                            caramels apple pie lollipop jujubes.
                        </div>
                        <div class="mb-2">
                            <div class="br-wrapper br-theme-cs-icon d-inline-block">
                                <select class="rating" name="rating" autocomplete="off"
                                    data-readonly="true" data-initial-rating="5">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="text-muted d-inline-block text-small align-text-top">(572)</div>
                        </div>
                        <div>$ 27.50</div>
                    </div>
                    <div>
                        <a href="Course.Detail.html"
                            class="btn btn-icon btn-icon-start btn-primary mt-3 stretched-link">
                            <i data-acorn-icon="chevron-right"></i>
                            <span>View</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Recommended Courses End -->
    </div>

    <!-- Achievements Start -->
    <h2 class="small-title">Achievements</h2>
    <div class="row gx-2">
        <div class="col-12 p-0">
            <div class="glide" id="glideAchievements">
                <div class="glide__track" data-glide-el="track">
                    <div class="glide__slides">
                        <div class="glide__slide">
                            <div class="card mb-5 sh-25">
                                <div
                                    class="card-body text-center align-items-center d-flex flex-column justify-content-between">
                                    <div
                                        class="d-flex sw-6 sh-6 bg-gradient-light mb-4 align-items-center justify-content-center rounded-xl position-relative mt-3">
                                        <i data-acorn-icon="badge" class="text-white"></i>
                                        <div class="achievement bg position-absolute">
                                            <svg width="75" height="75" viewBox="0 0 75 75"
                                                fill="black" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M15.3422 7.24333C21.5482 2.69119 29.2117 0 37.5 0C45.7883 0 53.4518 2.69119 59.6578 7.24333C60.5562 7.90233 60.7431 9.15516 60.0752 10.0416C59.4073 10.9281 58.1375 11.1124 57.2391 10.4534C51.7048 6.39402 44.8833 4 37.5 4C30.1167 4 23.2952 6.39403 17.7609 10.4535C16.8625 11.1124 15.5927 10.9281 14.9248 10.0416C14.2569 9.15516 14.4438 7.90233 15.3422 7.24333ZM65.0942 15.1001C66.006 14.4592 67.2717 14.6688 67.9213 15.5684C72.3763 21.7377 75 29.3164 75 37.5C75 45.6836 72.3763 53.2623 67.9213 59.4316C67.2717 60.3311 66.006 60.5408 65.0942 59.8999C64.1825 59.2589 63.97 58.0101 64.6196 57.1105C68.599 51.5998 70.9459 44.8284 70.9459 37.5C70.9459 30.1716 68.599 23.4002 64.6196 17.8895C63.97 16.9899 64.1825 15.7411 65.0942 15.1001ZM9.90579 15.1001C10.8175 15.7411 11.03 16.9899 10.3804 17.8895C6.40105 23.4002 4.05405 30.1716 4.05405 37.5C4.05405 44.8284 6.40105 51.5998 10.3804 57.1105C11.03 58.0101 10.8175 59.2589 9.90579 59.8999C8.99405 60.5408 7.72832 60.3312 7.07871 59.4316C2.62373 53.2623 0 45.6836 0 37.5C0 29.3164 2.62373 21.7377 7.07871 15.5684C7.72832 14.6689 8.99404 14.4592 9.90579 15.1001ZM14.9248 64.9584C15.5927 64.0719 16.8625 63.8876 17.7609 64.5466C23.2952 68.606 30.1167 71 37.5 71C44.8833 71 51.7048 68.606 57.2391 64.5465C58.1375 63.8876 59.4073 64.0719 60.0752 64.9584C60.7431 65.8448 60.5562 67.0977 59.6578 67.7567C53.4518 72.3088 45.7883 75 37.5 75C29.2117 75 21.5483 72.3088 15.3422 67.7567C14.4438 67.0977 14.2569 65.8448 14.9248 64.9584Z" />
                                            </svg>
                                        </div>
                                        <div class="achievement level position-absolute">
                                            <svg width="75" height="75" viewBox="0 0 75 75"
                                                fill="black" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M15.3422 7.24333C21.5482 2.69119 29.2117 0 37.5 0C45.7883 0 53.4517 2.69119 59.6578 7.24333C60.5562 7.90233 60.7431 9.15516 60.0752 10.0416C59.4073 10.9281 58.1375 11.1124 57.2391 10.4534C51.7048 6.39402 44.8833 4 37.5 4C30.1167 4 23.2952 6.39403 17.7609 10.4535C16.8625 11.1124 15.5927 10.9281 14.9248 10.0416C14.2569 9.15516 14.4438 7.90233 15.3422 7.24333Z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="card-text mb-0 d-flex">Javascript Novice</p>
                                    <p class="text-center mb-0 d-flex text-primary">Level 1</p>
                                </div>
                            </div>
                        </div>
                        <div class="glide__slide">
                            <div class="card mb-5 sh-25">
                                <div
                                    class="card-body text-center align-items-center d-flex flex-column justify-content-between">
                                    <div
                                        class="d-flex sw-6 sh-6 bg-gradient-light mb-4 align-items-center justify-content-center rounded-xl position-relative mt-3">
                                        <i data-acorn-icon="prize" class="text-white"></i>
                                        <div class="achievement bg position-absolute">
                                            <svg width="75" height="75" viewBox="0 0 75 75"
                                                fill="black" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M15.3422 7.24333C21.5482 2.69119 29.2117 0 37.5 0C45.7883 0 53.4518 2.69119 59.6578 7.24333C60.5562 7.90233 60.7431 9.15516 60.0752 10.0416C59.4073 10.9281 58.1375 11.1124 57.2391 10.4534C51.7048 6.39402 44.8833 4 37.5 4C30.1167 4 23.2952 6.39403 17.7609 10.4535C16.8625 11.1124 15.5927 10.9281 14.9248 10.0416C14.2569 9.15516 14.4438 7.90233 15.3422 7.24333ZM65.0942 15.1001C66.006 14.4592 67.2717 14.6688 67.9213 15.5684C72.3763 21.7377 75 29.3164 75 37.5C75 45.6836 72.3763 53.2623 67.9213 59.4316C67.2717 60.3311 66.006 60.5408 65.0942 59.8999C64.1825 59.2589 63.97 58.0101 64.6196 57.1105C68.599 51.5998 70.9459 44.8284 70.9459 37.5C70.9459 30.1716 68.599 23.4002 64.6196 17.8895C63.97 16.9899 64.1825 15.7411 65.0942 15.1001ZM9.90579 15.1001C10.8175 15.7411 11.03 16.9899 10.3804 17.8895C6.40105 23.4002 4.05405 30.1716 4.05405 37.5C4.05405 44.8284 6.40105 51.5998 10.3804 57.1105C11.03 58.0101 10.8175 59.2589 9.90579 59.8999C8.99405 60.5408 7.72832 60.3312 7.07871 59.4316C2.62373 53.2623 0 45.6836 0 37.5C0 29.3164 2.62373 21.7377 7.07871 15.5684C7.72832 14.6689 8.99404 14.4592 9.90579 15.1001ZM14.9248 64.9584C15.5927 64.0719 16.8625 63.8876 17.7609 64.5466C23.2952 68.606 30.1167 71 37.5 71C44.8833 71 51.7048 68.606 57.2391 64.5465C58.1375 63.8876 59.4073 64.0719 60.0752 64.9584C60.7431 65.8448 60.5562 67.0977 59.6578 67.7567C53.4518 72.3088 45.7883 75 37.5 75C29.2117 75 21.5483 72.3088 15.3422 67.7567C14.4438 67.0977 14.2569 65.8448 14.9248 64.9584Z" />
                                            </svg>
                                        </div>
                                        <div class="achievement level position-absolute">
                                            <svg width="75" height="75" viewBox="0 0 75 75"
                                                fill="black" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M15.3422 7.24333C21.5482 2.69119 29.2117 0 37.5 0C45.7883 0 53.4517 2.69119 59.6578 7.24333C60.5562 7.90233 60.7431 9.15516 60.0752 10.0416C59.4073 10.9281 58.1375 11.1124 57.2391 10.4534C51.7048 6.39402 44.8833 4 37.5 4C30.1167 4 23.2952 6.39403 17.7609 10.4535C16.8625 11.1124 15.5927 10.9281 14.9248 10.0416C14.2569 9.15516 14.4438 7.90233 15.3422 7.24333ZM65.0942 15.1001C66.006 14.4592 67.2717 14.6688 67.9213 15.5684C72.3763 21.7377 75 29.3164 75 37.5C75 45.6836 72.3763 53.2623 67.9213 59.4316C67.2717 60.3311 66.006 60.5408 65.0942 59.8999C64.1825 59.2589 63.97 58.0101 64.6196 57.1105C68.599 51.5998 70.9459 44.8284 70.9459 37.5C70.9459 30.1716 68.5989 23.4002 64.6196 17.8895C63.97 16.9899 64.1825 15.7411 65.0942 15.1001ZM14.9248 64.9584C15.5927 64.0719 16.8625 63.8876 17.7609 64.5466C23.2952 68.606 30.1167 71 37.5 71C44.8833 71 51.7048 68.606 57.2391 64.5465C58.1375 63.8876 59.4073 64.0719 60.0752 64.9584C60.7431 65.8448 60.5562 67.0977 59.6578 67.7567C53.4517 72.3088 45.7883 75 37.5 75C29.2117 75 21.5482 72.3088 15.3422 67.7567C14.4438 67.0977 14.2569 65.8448 14.9248 64.9584Z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="card-text mb-0 d-flex">CSS Expert</p>
                                    <p class="text-center mb-0 d-flex text-primary">Level 3</p>
                                </div>
                            </div>
                        </div>
                        <div class="glide__slide">
                            <div class="card mb-5 sh-25">
                                <div
                                    class="card-body text-center align-items-center d-flex flex-column justify-content-between">
                                    <div
                                        class="d-flex sw-6 sh-6 bg-gradient-light mb-4 align-items-center justify-content-center rounded-xl position-relative mt-3">
                                        <i data-acorn-icon="medal" class="text-white"></i>
                                        <div class="achievement bg position-absolute">
                                            <svg width="75" height="75" viewBox="0 0 75 75"
                                                fill="black" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M15.3422 7.24333C21.5482 2.69119 29.2117 0 37.5 0C45.7883 0 53.4518 2.69119 59.6578 7.24333C60.5562 7.90233 60.7431 9.15516 60.0752 10.0416C59.4073 10.9281 58.1375 11.1124 57.2391 10.4534C51.7048 6.39402 44.8833 4 37.5 4C30.1167 4 23.2952 6.39403 17.7609 10.4535C16.8625 11.1124 15.5927 10.9281 14.9248 10.0416C14.2569 9.15516 14.4438 7.90233 15.3422 7.24333ZM65.0942 15.1001C66.006 14.4592 67.2717 14.6688 67.9213 15.5684C72.3763 21.7377 75 29.3164 75 37.5C75 45.6836 72.3763 53.2623 67.9213 59.4316C67.2717 60.3311 66.006 60.5408 65.0942 59.8999C64.1825 59.2589 63.97 58.0101 64.6196 57.1105C68.599 51.5998 70.9459 44.8284 70.9459 37.5C70.9459 30.1716 68.599 23.4002 64.6196 17.8895C63.97 16.9899 64.1825 15.7411 65.0942 15.1001ZM9.90579 15.1001C10.8175 15.7411 11.03 16.9899 10.3804 17.8895C6.40105 23.4002 4.05405 30.1716 4.05405 37.5C4.05405 44.8284 6.40105 51.5998 10.3804 57.1105C11.03 58.0101 10.8175 59.2589 9.90579 59.8999C8.99405 60.5408 7.72832 60.3312 7.07871 59.4316C2.62373 53.2623 0 45.6836 0 37.5C0 29.3164 2.62373 21.7377 7.07871 15.5684C7.72832 14.6689 8.99404 14.4592 9.90579 15.1001ZM14.9248 64.9584C15.5927 64.0719 16.8625 63.8876 17.7609 64.5466C23.2952 68.606 30.1167 71 37.5 71C44.8833 71 51.7048 68.606 57.2391 64.5465C58.1375 63.8876 59.4073 64.0719 60.0752 64.9584C60.7431 65.8448 60.5562 67.0977 59.6578 67.7567C53.4518 72.3088 45.7883 75 37.5 75C29.2117 75 21.5483 72.3088 15.3422 67.7567C14.4438 67.0977 14.2569 65.8448 14.9248 64.9584Z" />
                                            </svg>
                                        </div>
                                        <div class="achievement level position-absolute">
                                            <svg width="75" height="75" viewBox="0 0 75 75"
                                                fill="black" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M15.3422 7.24333C21.5482 2.69119 29.2117 0 37.5 0C45.7883 0 53.4517 2.69119 59.6578 7.24333C60.5562 7.90233 60.7431 9.15516 60.0752 10.0416C59.4073 10.9281 58.1375 11.1124 57.2391 10.4534C51.7048 6.39402 44.8833 4 37.5 4C30.1167 4 23.2952 6.39403 17.7609 10.4535C16.8625 11.1124 15.5927 10.9281 14.9248 10.0416C14.2569 9.15516 14.4438 7.90233 15.3422 7.24333ZM65.0942 15.1001C66.006 14.4592 67.2717 14.6688 67.9213 15.5684C72.3763 21.7377 75 29.3164 75 37.5C75 45.6836 72.3763 53.2623 67.9213 59.4316C67.2717 60.3311 66.006 60.5408 65.0942 59.8999C64.1825 59.2589 63.97 58.0101 64.6196 57.1105C68.599 51.5998 70.9459 44.8284 70.9459 37.5C70.9459 30.1716 68.5989 23.4002 64.6196 17.8895C63.97 16.9899 64.1825 15.7411 65.0942 15.1001Z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="card-text mb-0 d-flex">HTML Apprentice</p>
                                    <p class="text-center mb-0 d-flex text-primary">Level 2</p>
                                </div>
                            </div>
                        </div>
                        <div class="glide__slide">
                            <div class="card mb-5 sh-25">
                                <div
                                    class="card-body text-center align-items-center d-flex flex-column justify-content-between">
                                    <div
                                        class="d-flex sw-6 sh-6 bg-gradient-light mb-4 align-items-center justify-content-center rounded-xl position-relative mt-3">
                                        <i data-acorn-icon="star" class="text-white"></i>
                                        <div class="achievement bg position-absolute">
                                            <svg width="75" height="75" viewBox="0 0 75 75"
                                                fill="black" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M15.3422 7.24333C21.5482 2.69119 29.2117 0 37.5 0C45.7883 0 53.4518 2.69119 59.6578 7.24333C60.5562 7.90233 60.7431 9.15516 60.0752 10.0416C59.4073 10.9281 58.1375 11.1124 57.2391 10.4534C51.7048 6.39402 44.8833 4 37.5 4C30.1167 4 23.2952 6.39403 17.7609 10.4535C16.8625 11.1124 15.5927 10.9281 14.9248 10.0416C14.2569 9.15516 14.4438 7.90233 15.3422 7.24333ZM65.0942 15.1001C66.006 14.4592 67.2717 14.6688 67.9213 15.5684C72.3763 21.7377 75 29.3164 75 37.5C75 45.6836 72.3763 53.2623 67.9213 59.4316C67.2717 60.3311 66.006 60.5408 65.0942 59.8999C64.1825 59.2589 63.97 58.0101 64.6196 57.1105C68.599 51.5998 70.9459 44.8284 70.9459 37.5C70.9459 30.1716 68.599 23.4002 64.6196 17.8895C63.97 16.9899 64.1825 15.7411 65.0942 15.1001ZM9.90579 15.1001C10.8175 15.7411 11.03 16.9899 10.3804 17.8895C6.40105 23.4002 4.05405 30.1716 4.05405 37.5C4.05405 44.8284 6.40105 51.5998 10.3804 57.1105C11.03 58.0101 10.8175 59.2589 9.90579 59.8999C8.99405 60.5408 7.72832 60.3312 7.07871 59.4316C2.62373 53.2623 0 45.6836 0 37.5C0 29.3164 2.62373 21.7377 7.07871 15.5684C7.72832 14.6689 8.99404 14.4592 9.90579 15.1001ZM14.9248 64.9584C15.5927 64.0719 16.8625 63.8876 17.7609 64.5466C23.2952 68.606 30.1167 71 37.5 71C44.8833 71 51.7048 68.606 57.2391 64.5465C58.1375 63.8876 59.4073 64.0719 60.0752 64.9584C60.7431 65.8448 60.5562 67.0977 59.6578 67.7567C53.4518 72.3088 45.7883 75 37.5 75C29.2117 75 21.5483 72.3088 15.3422 67.7567C14.4438 67.0977 14.2569 65.8448 14.9248 64.9584Z" />
                                            </svg>
                                        </div>
                                        <div class="achievement level position-absolute">
                                            <svg width="75" height="75" viewBox="0 0 75 75"
                                                fill="black" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M15.3422 7.24333C21.5482 2.69119 29.2117 0 37.5 0C45.7883 0 53.4517 2.69119 59.6578 7.24333C60.5562 7.90233 60.7431 9.15516 60.0752 10.0416C59.4073 10.9281 58.1375 11.1124 57.2391 10.4534C51.7048 6.39402 44.8833 4 37.5 4C30.1167 4 23.2952 6.39403 17.7609 10.4535C16.8625 11.1124 15.5927 10.9281 14.9248 10.0416C14.2569 9.15516 14.4438 7.90233 15.3422 7.24333Z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="card-text mb-0 d-flex">Php Novice</p>
                                    <p class="text-center mb-0 d-flex text-primary">Level 1</p>
                                </div>
                            </div>
                        </div>
                        <div class="glide__slide">
                            <div class="card mb-5 sh-25">
                                <div
                                    class="card-body text-center align-items-center d-flex flex-column justify-content-between">
                                    <div
                                        class="d-flex sw-6 sh-6 bg-gradient-light mb-4 align-items-center justify-content-center rounded-xl position-relative mt-3">
                                        <i data-acorn-icon="crown" class="text-white"></i>
                                        <div class="achievement bg position-absolute">
                                            <svg width="75" height="75" viewBox="0 0 75 75"
                                                fill="black" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M15.3422 7.24333C21.5482 2.69119 29.2117 0 37.5 0C45.7883 0 53.4518 2.69119 59.6578 7.24333C60.5562 7.90233 60.7431 9.15516 60.0752 10.0416C59.4073 10.9281 58.1375 11.1124 57.2391 10.4534C51.7048 6.39402 44.8833 4 37.5 4C30.1167 4 23.2952 6.39403 17.7609 10.4535C16.8625 11.1124 15.5927 10.9281 14.9248 10.0416C14.2569 9.15516 14.4438 7.90233 15.3422 7.24333ZM65.0942 15.1001C66.006 14.4592 67.2717 14.6688 67.9213 15.5684C72.3763 21.7377 75 29.3164 75 37.5C75 45.6836 72.3763 53.2623 67.9213 59.4316C67.2717 60.3311 66.006 60.5408 65.0942 59.8999C64.1825 59.2589 63.97 58.0101 64.6196 57.1105C68.599 51.5998 70.9459 44.8284 70.9459 37.5C70.9459 30.1716 68.599 23.4002 64.6196 17.8895C63.97 16.9899 64.1825 15.7411 65.0942 15.1001ZM9.90579 15.1001C10.8175 15.7411 11.03 16.9899 10.3804 17.8895C6.40105 23.4002 4.05405 30.1716 4.05405 37.5C4.05405 44.8284 6.40105 51.5998 10.3804 57.1105C11.03 58.0101 10.8175 59.2589 9.90579 59.8999C8.99405 60.5408 7.72832 60.3312 7.07871 59.4316C2.62373 53.2623 0 45.6836 0 37.5C0 29.3164 2.62373 21.7377 7.07871 15.5684C7.72832 14.6689 8.99404 14.4592 9.90579 15.1001ZM14.9248 64.9584C15.5927 64.0719 16.8625 63.8876 17.7609 64.5466C23.2952 68.606 30.1167 71 37.5 71C44.8833 71 51.7048 68.606 57.2391 64.5465C58.1375 63.8876 59.4073 64.0719 60.0752 64.9584C60.7431 65.8448 60.5562 67.0977 59.6578 67.7567C53.4518 72.3088 45.7883 75 37.5 75C29.2117 75 21.5483 72.3088 15.3422 67.7567C14.4438 67.0977 14.2569 65.8448 14.9248 64.9584Z" />
                                            </svg>
                                        </div>
                                        <div class="achievement level position-absolute">
                                            <svg width="75" height="75" viewBox="0 0 75 75"
                                                fill="black" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M15.3422 7.24333C21.5482 2.69119 29.2117 0 37.5 0C45.7883 0 53.4518 2.69119 59.6578 7.24333C60.5562 7.90233 60.7431 9.15516 60.0752 10.0416C59.4073 10.9281 58.1375 11.1124 57.2391 10.4534C51.7048 6.39402 44.8833 4 37.5 4C30.1167 4 23.2952 6.39403 17.7609 10.4535C16.8625 11.1124 15.5927 10.9281 14.9248 10.0416C14.2569 9.15516 14.4438 7.90233 15.3422 7.24333ZM65.0942 15.1001C66.006 14.4592 67.2717 14.6688 67.9213 15.5684C72.3763 21.7377 75 29.3164 75 37.5C75 45.6836 72.3763 53.2623 67.9213 59.4316C67.2717 60.3311 66.006 60.5408 65.0942 59.8999C64.1825 59.2589 63.97 58.0101 64.6196 57.1105C68.599 51.5998 70.9459 44.8284 70.9459 37.5C70.9459 30.1716 68.599 23.4002 64.6196 17.8895C63.97 16.9899 64.1825 15.7411 65.0942 15.1001ZM9.90579 15.1001C10.8175 15.7411 11.03 16.9899 10.3804 17.8895C6.40105 23.4002 4.05405 30.1716 4.05405 37.5C4.05405 44.8284 6.40105 51.5998 10.3804 57.1105C11.03 58.0101 10.8175 59.2589 9.90579 59.8999C8.99405 60.5408 7.72832 60.3312 7.07871 59.4316C2.62373 53.2623 0 45.6836 0 37.5C0 29.3164 2.62373 21.7377 7.07871 15.5684C7.72832 14.6689 8.99404 14.4592 9.90579 15.1001ZM14.9248 64.9584C15.5927 64.0719 16.8625 63.8876 17.7609 64.5466C23.2952 68.606 30.1167 71 37.5 71C44.8833 71 51.7048 68.606 57.2391 64.5465C58.1375 63.8876 59.4073 64.0719 60.0752 64.9584C60.7431 65.8448 60.5562 67.0977 59.6578 67.7567C53.4518 72.3088 45.7883 75 37.5 75C29.2117 75 21.5483 72.3088 15.3422 67.7567C14.4438 67.0977 14.2569 65.8448 14.9248 64.9584Z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="card-text mb-0 d-flex">Python Master</p>
                                    <p class="text-center mb-0 d-flex text-primary">Level 2</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Achievements End -->

    <!-- Trending Courses Start -->
    <h2 class="small-title">Trending Courses</h2>
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-5 g-2 mb-5">
        <div class="col">
            <div class="card h-100">
                <img src="img/course/small/course-4.webp" class="card-img-top sh-22" alt="card image" />
                <div class="card-body">
                    <h5 class="heading mb-0"><a href="Course.Detail.html"
                            class="body-link stretched-link">Introduction to Bread Making</a></h5>
                </div>
                <div class="card-footer border-0 pt-0">
                    <div class="mb-2">
                        <div class="br-wrapper br-theme-cs-icon d-inline-block">
                            <select class="rating" name="rating" autocomplete="off"
                                data-readonly="true" data-initial-rating="5">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="text-muted d-inline-block text-small align-text-top">(39)</div>
                    </div>
                    <div class="card-text mb-0">
                        <div class="text-muted text-overline text-small">
                            <del>$ 42.25</del>
                        </div>
                        <div>$ 27.50</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <img src="img/course/small/course-5.webp" class="card-img-top sh-22" alt="card image" />
                <div class="card-body">
                    <h5 class="heading mb-0"><a href="Course.Detail.html"
                            class="body-link stretched-link">14 Facts About Sugar</a></h5>
                </div>
                <div class="card-footer border-0 pt-0">
                    <div class="mb-2">
                        <div class="br-wrapper br-theme-cs-icon d-inline-block">
                            <select class="rating" name="rating" autocomplete="off"
                                data-readonly="true" data-initial-rating="5">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="text-muted d-inline-block text-small align-text-top">(221)</div>
                    </div>
                    <div class="card-text mb-0">
                        <div class="text-muted text-overline text-small">
                            <del>$ 36.50</del>
                        </div>
                        <div>$ 15.25</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <span
                    class="badge rounded-pill bg-primary me-1 position-absolute e-3 t-3 z-index-1">POPULAR</span>
                <img src="img/course/small/course-6.webp" class="card-img-top sh-22" alt="card image" />
                <div class="card-body">
                    <h5 class="heading mb-0"><a href="Course.Detail.html"
                            class="body-link stretched-link">Apple Cake Recipe</a></h5>
                </div>
                <div class="card-footer border-0 pt-0">
                    <div class="mb-2">
                        <div class="br-wrapper br-theme-cs-icon d-inline-block">
                            <select class="rating" name="rating" autocomplete="off"
                                data-readonly="true" data-initial-rating="5">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="text-muted d-inline-block text-small align-text-top">(572)</div>
                    </div>
                    <div class="card-text mb-0">
                        <div class="text-muted text-overline text-small">
                            <del>$ 51.00</del>
                        </div>
                        <div>$ 36.80</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <img src="img/course/small/course-7.webp" class="card-img-top sh-22" alt="card image" />
                <div class="card-body">
                    <h5 class="heading mb-0"><a href="Course.Detail.html"
                            class="body-link stretched-link">Dough for the Molds</a></h5>
                </div>
                <div class="card-footer border-0 pt-0">
                    <div class="mb-2">
                        <div class="br-wrapper br-theme-cs-icon d-inline-block">
                            <select class="rating" name="rating" autocomplete="off"
                                data-readonly="true" data-initial-rating="5">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="text-muted d-inline-block text-small align-text-top">(25)</div>
                    </div>
                    <div class="card-text mb-0">
                        <div class="text-muted text-overline text-small">
                            <del>$ 18.25</del>
                        </div>
                        <div>$ 11.00</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col d-none d-xl-block">
            <div class="card h-100">
                <img src="img/course/small/course-9.webp" class="card-img-top sh-22" alt="card image" />
                <div class="card-body">
                    <h5 class="heading mb-0"><a href="Course.Detail.html"
                            class="body-link stretched-link">Fruit Decorations</a></h5>
                </div>
                <div class="card-footer border-0 pt-0">
                    <div class="mb-2">
                        <div class="br-wrapper br-theme-cs-icon d-inline-block">
                            <select class="rating" name="rating" autocomplete="off"
                                data-readonly="true" data-initial-rating="5">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="text-muted d-inline-block text-small align-text-top">(472)</div>
                    </div>
                    <div class="card-text mb-0">
                        <div class="text-muted text-overline text-small">
                            <del>$ 24.00</del>
                        </div>
                        <div>$ 14.90</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Trending Courses End -->

    <div class="row">
        <!-- Related Subjects Start -->
        <div class="col-xl-4 mb-5">
            <h2 class="small-title">Related Subjects</h2>
            <div class="row g-2">
                <div class="col-6 col-xl-6 sh-19">
                    <div class="card h-100 hover-scale-up">
                        <a class="card-body text-center" href="Course.List.html">
                            <i data-acorn-icon="cupcake" class="text-primary"></i>
                            <p class="heading mt-3 text-body">Cupcakes</p>
                            <div class="text-extra-small fw-medium text-muted">14 COURSES</div>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-xl-6 sh-19">
                    <div class="card h-100 hover-scale-up">
                        <a class="card-body text-center" href="Course.List.html">
                            <i data-acorn-icon="loaf" class="text-primary"></i>
                            <p class="heading mt-3 text-body">Breads</p>
                            <div class="text-extra-small fw-medium text-muted">3 COURSES</div>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-xl-6 sh-19">
                    <div class="card h-100 hover-scale-up">
                        <a class="card-body text-center" href="Course.List.html">
                            <i data-acorn-icon="radish" class="text-primary"></i>
                            <p class="heading mt-3 text-body">Vegetables</p>
                            <div class="text-extra-small fw-medium text-muted">8 COURSES</div>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-xl-6 sh-19">
                    <div class="card h-100 hover-scale-up">
                        <a class="card-body text-center" href="Course.List.html">
                            <i data-acorn-icon="banana" class="text-primary"></i>
                            <p class="heading mt-3 text-body">Fruits</p>
                            <div class="text-extra-small fw-medium text-muted">9 COURSES</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Related Subjects End -->

        <!-- Your Time Start -->
        <div class="col-xl-4 mb-5">
            <h2 class="small-title">Your Time</h2>
            <div class="card sh-40 h-xl-100-card">
                <div class="card-body h-100">
                    <div class="h-100">
                        <canvas id="timeChart"></canvas>
                        <div
                            class="custom-tooltip position-absolute bg-foreground rounded-md border border-separator pe-none p-3 d-flex flex-column z-index-1 align-items-center opacity-0 basic-transform-transition">
                            <div
                                class="icon-container border d-flex align-items-center justify-content-center align-self-center rounded-xl sh-5 sw-5 rounded-xl mb-3">
                                <span class="icon"></span>
                            </div>
                            <span
                                class="text d-flex align-middle text-alternate align-items-center text-small">Bread</span>
                            <span
                                class="value d-flex align-middle text-body align-items-center cta-4">300</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Your Time End -->

        <!-- Paths Start -->
        <div class="col-xl-4 mb-5">
            <h2 class="small-title">Paths</h2>
            <div class="card sh-40 h-xl-100-card">
                <div class="card-body d-flex align-items-center justify-content-center h-100">
                    <div class="text-center">
                        <img src="img/illustration/icon-analytics.webp" class="theme-filter mb-3"
                            alt="launch" />
                        <p class="mb-3">You are not on any path!</p>
                        <a href="Path.List.html"
                            class="btn btn-icon btn-icon-start btn-primary mt-3 stretched-link">
                            <i data-acorn-icon="chevron-right"></i>
                            <span>Take a Path</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Paths End -->
    </div>

    <!-- Content End -->
</div>
@endsection
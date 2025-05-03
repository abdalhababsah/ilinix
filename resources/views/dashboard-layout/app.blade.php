<!DOCTYPE html>
<html lang="en" data-footer="true">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Acorn Admin Template | Dashboards Elearning</title>
    <meta name="description" content="Acorn elearning platform dashboard." />
    <!-- Favicon Tags Start -->
    <link rel="apple-touch-icon-precomposed" sizes="57x57"
        href="{{ asset('dashboard/img/favicon/apple-touch-icon-57x57.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href="{{ asset('dashboard/img/favicon/apple-touch-icon-114x114.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
        href="{{ asset('dashboard/img/favicon/apple-touch-icon-72x72.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="{{ asset('dashboard/img/favicon/apple-touch-icon-144x144.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="60x60"
        href="{{ asset('dashboard/img/favicon/apple-touch-icon-60x60.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="120x120"
        href="{{ asset('dashboard/img/favicon/apple-touch-icon-120x120.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="76x76"
        href="{{ asset('dashboard/img/favicon/apple-touch-icon-76x76.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152"
        href="{{ asset('dashboard/img/favicon/apple-touch-icon-152x152.png') }}" />
    <link rel="icon" type="image/png" href="{{ asset('dashboard/img/favicon/favicon-196x196.png') }}"
        sizes="196x196" />
    <link rel="icon" type="image/png" href="{{ asset('dashboard/img/favicon/favicon-96x96.png') }}"
        sizes="96x96" />
    <link rel="icon" type="image/png" href="{{ asset('dashboard/img/favicon/favicon-32x32.png') }}"
        sizes="32x32" />
    <link rel="icon" type="image/png" href="{{ asset('dashboard/img/favicon/favicon-16x16.png') }}"
        sizes="16x16" />
    <link rel="icon" type="image/png" href="{{ asset('dashboard/img/favicon/favicon-128.png') }}"
        sizes="128x128" />
    <meta name="application-name" content="&nbsp;" />
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta name="msapplication-TileImage" content="{{ asset('dashboard/img/favicon/mstile-144x144.png') }}" />
    <meta name="msapplication-square70x70logo" content="{{ asset('dashboard/img/favicon/mstile-70x70.png') }}" />
    <meta name="msapplication-square150x150logo" content="{{ asset('dashboard/img/favicon/mstile-150x150.png') }}" />
    <meta name="msapplication-wide310x150logo" content="{{ asset('dashboard/img/favicon/mstile-310x150.png') }}" />
    <meta name="msapplication-square310x310logo" content="{{ asset('dashboard/img/favicon/mstile-310x310.png') }}" />
    <!-- Favicon Tags End -->
    <!-- Font Tags Start -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('dashboard/font/CS-Interface/style.css') }}" />
    <!-- Font Tags End -->
    <!-- Vendor Styles Start -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/vendor/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/css/vendor/OverlayScrollbars.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/css/vendor/glide.core.min.css') }}" />
    <!-- Vendor Styles End -->
    <!-- Template Base Styles Start -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/styles.css') }}" />
    <!-- Template Base Styles End -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/main.css') }}" />
    <script src="{{ asset('dashboard/js/base/loader.js') }}"></script>
</head>

<body>
    <div id="root">
        @include('dashboard-layout.sidebar')

        <main>
            @yield('content')
        </main>
        <!-- Layout Footer Start -->
        @include('dashboard-layout.footer')
        <!-- Layout Footer End -->
    </div>
    <!-- Theme Settings Modal Start -->
    @include('dashboard-layout.theme-settings')

    <!-- Search Modal End -->
    <!-- Vendor Scripts Start -->
    <script src="{{ asset('dashboard/js/vendor/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/vendor/OverlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/vendor/autoComplete.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/vendor/clamp.min.js') }}"></script>
    <script src="{{ asset('dashboard/icon/acorn-icons.js') }}"></script>
    <script src="{{ asset('dashboard/icon/acorn-icons-interface.js') }}"></script>
    <script src="{{ asset('dashboard/icon/acorn-icons-learning.js') }}"></script>

    <script src="{{ asset('dashboard/js/vendor/glide.min.js') }}"></script>

    <script src="{{ asset('dashboard/js/vendor/Chart.bundle.min.js') }}"></script>

    <script src="{{ asset('dashboard/js/vendor/jquery.barrating.min.js') }}"></script>

    <!-- Vendor Scripts End -->

    <!-- Template Base Scripts Start -->
    <script src="{{ asset('dashboard/js/base/helpers.js') }}"></script>
    <script src="{{ asset('dashboard/js/base/globals.js') }}"></script>
    <script src="{{ asset('dashboard/js/base/nav.js') }}"></script>
    <script src="{{ asset('dashboard/js/base/search.js') }}"></script>
    <script src="{{ asset('dashboard/js/base/settings.js') }}"></script>
    <!-- Template Base Scripts End -->
    <!-- Page Specific Scripts Start -->

    <script src="{{ asset('dashboard/js/cs/glide.custom.js') }}"></script>

    <script src="{{ asset('dashboard/js/cs/charts.extend.js') }}"></script>

    <script src="{{ asset('dashboard/js/pages/dashboard.elearning.js') }}"></script>

    <script src="{{ asset('dashboard/js/common.js') }}"></script>
    <script src="{{ asset('dashboard/js/scripts.js') }}"></script>
    <!-- Page Specific Scripts End -->
</body>

</html>

<!DOCTYPE html>
<html lang="en" data-footer="true">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5" />
    <title>ilinix | Modern Cloud Contact Center Solutions</title>
    <meta name="description" content="ilinix offers AI-enriched contact center solutions that help businesses create exceptional customer experiences across 165+ countries. No upfront payments, no long-term commitments." />
    <meta name="keywords" content="contact center, AI solutions, cloud contact center, customer experience, CX solutions, omnichannel, Smart IVR, CCaaS" />
    <meta name="author" content="ilinix" />
    <meta name="robots" content="index, follow" />
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}" />
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:title" content="ilinix | Modern Cloud Contact Center Solutions" />
    <meta property="og:description" content="AI-enriched contact center solutions that help businesses create exceptional customer experiences. No upfront payments, no long-term commitments." />
    <meta property="og:image" content="{{ asset('dashboard-assets/img/logo/logo-white.svg') }}" />
    <meta property="og:site_name" content="ilinix" />
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@ilinix" />
    <meta name="twitter:title" content="ilinix | Modern Cloud Contact Center Solutions" />
    <meta name="twitter:description" content="Turn first-time callers into lifetime customers with AI-enriched contact solutions. Serving 165+ countries globally." />
    <meta name="twitter:image" content="{{ asset('dashboard-assets/img/logo/logo-white.svg') }}" />
    
    <!-- App Info -->
    <meta name="application-name" content="ilinix" />
    <meta name="apple-mobile-web-app-title" content="ilinix" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="theme-color" content="#4285f4" />
    <meta name="msapplication-TileColor" content="#4285f4" />
    
    <!-- Favicon Tags Start -->
    <link rel="icon" href="{{ asset('dashboard-assets/img/logo/logo-white.svg') }}" type="image/svg+xml" />
    <link rel="shortcut icon" href="{{ asset('dashboard-assets/img/logo/logo-white.svg') }}" type="image/svg+xml" />
    <link rel="apple-touch-icon" href="{{ asset('dashboard-assets/img/logo/logo-white.svg') }}" />
    <link rel="mask-icon" href="{{ asset('dashboard-assets/img/logo/logo-white.svg') }}" color="#4285f4" />
    
    <!-- Legacy Favicon Support for Various Devices -->
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="{{ asset('dashboard-assets/img/favicon/apple-touch-icon-57x57.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('dashboard-assets/img/favicon/apple-touch-icon-114x114.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('dashboard-assets/img/favicon/apple-touch-icon-72x72.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('dashboard-assets/img/favicon/apple-touch-icon-144x144.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="60x60" href="{{ asset('dashboard-assets/img/favicon/apple-touch-icon-60x60.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="{{ asset('dashboard-assets/img/favicon/apple-touch-icon-120x120.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="{{ asset('dashboard-assets/img/favicon/apple-touch-icon-76x76.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{ asset('dashboard-assets/img/favicon/apple-touch-icon-152x152.png') }}" />
    <link rel="icon" type="image/png" href="{{ asset('dashboard-assets/img/favicon/favicon-196x196.png') }}" sizes="196x196" />
    <link rel="icon" type="image/png" href="{{ asset('dashboard-assets/img/favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/png" href="{{ asset('dashboard-assets/img/favicon/favicon-32x32.png') }}" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{ asset('dashboard-assets/img/favicon/favicon-16x16.png') }}" sizes="16x16" />
    <link rel="icon" type="image/png" href="{{ asset('dashboard-assets/img/favicon/favicon-128.png') }}" sizes="128x128" />
    <meta name="msapplication-TileImage" content="{{ asset('dashboard-assets/img/favicon/mstile-144x144.png') }}" />
    <meta name="msapplication-square70x70logo" content="{{ asset('dashboard-assets/img/favicon/mstile-70x70.png') }}" />
    <meta name="msapplication-square150x150logo" content="{{ asset('dashboard-assets/img/favicon/mstile-150x150.png') }}" />
    <meta name="msapplication-wide310x150logo" content="{{ asset('dashboard-assets/img/favicon/mstile-310x150.png') }}" />
    <meta name="msapplication-square310x310logo" content="{{ asset('dashboard-assets/img/favicon/mstile-310x310.png') }}" />
    <!-- Favicon Tags End -->
    
    <!-- Performance Optimization -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin />
    <link rel="dns-prefetch" href="https://fonts.gstatic.com" />
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com" />
    
    <!-- Font Tags Start -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('dashboard-assets/font/CS-Interface/style.css') }}" />
    <!-- Font Tags End -->
    
    <!-- Vendor Styles Start -->
    <link rel="stylesheet" href="{{ asset('dashboard-assets/css/vendor/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard-assets/css/vendor/OverlayScrollbars.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard-assets/css/vendor/glide.core.min.css') }}" />
    <!-- Vendor Styles End -->
    
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "ilinix",
      "url": "{{ url('/') }}",
      "logo": "{{ asset('dashboard-assets/img/logo/logo-white.svg') }}",
      "description": "AI-enriched cloud contact center solutions that create exceptional customer experiences.",
      "sameAs": [
        "https://www.facebook.com/ilinix",
        "https://www.linkedin.com/company/ilinix",
        "https://twitter.com/ilinix"
      ],
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+1-800-123-4567",
        "contactType": "customer service",
        "availableLanguage": "English"
      }
    }
    </script>
    
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Service",
      "serviceType": "Cloud Contact Center Solutions",
      "provider": {
        "@type": "Organization",
        "name": "ilinix"
      },
      "description": "Modern cloud contact center solutions that help businesses create exceptional customer experiences through AI-enriched technology.",
      "areaServed": "Global",
      "hasOfferCatalog": {
        "@type": "OfferCatalog",
        "name": "ilinix Services",
        "itemListElement": [
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Service",
              "name": "Smart IVR",
              "description": "Deliver lifelike customer experiences that support accurate multi-turn conversations."
            }
          },
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Service",
              "name": "Omnichannel Support",
              "description": "Native support for voice, email and chat to meet users wherever they are."
            }
          }
        ]
      }
    }
    </script>
</head>
@viteReactRefresh
@vite(['resources/css/chat.css', 'resources/js/app.jsx'])
@inertiaHead
<body>
    @stack('styles')
    <div id="root">
        @include('dashboard-layout.sidebar')
        
        <main>
            @inertia
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
    <script src="{{ asset('dashboard-assets/js/vendor/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/js/vendor/OverlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/js/vendor/autoComplete.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/js/vendor/clamp.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/icon/acorn-icons.js') }}"></script>
    <script src="{{ asset('dashboard-assets/icon/acorn-icons-interface.js') }}"></script>
    <script src="{{ asset('dashboard-assets/icon/acorn-icons-learning.js') }}"></script>

    <script src="{{ asset('dashboard-assets/js/vendor/glide.min.js') }}"></script>

    <script src="{{ asset('dashboard-assets/js/vendor/Chart.bundle.min.js') }}"></script>

    <script src="{{ asset('dashboard-assets/js/vendor/jquery.barrating.min.js') }}"></script>
<!-- Add this to the <head> section of your HTML -->

<!-- Bootstrap JavaScript Bundle with Popper.js (Required for modals and other interactive components) -->
    <!-- Vendor Scripts End -->

    <!-- Template Base Scripts Start -->
    <script src="{{ asset('dashboard-assets/js/base/helpers.js') }}"></script>
    <script src="{{ asset('dashboard-assets/js/base/globals.js') }}"></script>
    <script src="{{ asset('dashboard-assets/js/base/nav.js') }}"></script>
    <script src="{{ asset('dashboard-assets/js/base/search.js') }}"></script>
    <script src="{{ asset('dashboard-assets/js/base/settings.js') }}"></script>
    <!-- Template Base Scripts End -->
    <!-- Page Specific Scripts Start -->

    <script src="{{ asset('dashboard-assets/js/cs/glide.custom.js') }}"></script>

    <script src="{{ asset('dashboard-assets/js/cs/charts.extend.js') }}"></script>

    <script src="{{ asset('dashboard-assets/js/pages/dashboard.elearning.js') }}"></script>

    <script src="{{ asset('dashboard-assets/js/common.js') }}"></script>
    <script src="{{ asset('dashboard-assets/js/scripts.js') }}"></script>


    @stack('scripts')
    <!-- Page Specific Scripts End -->
</body>

</html>

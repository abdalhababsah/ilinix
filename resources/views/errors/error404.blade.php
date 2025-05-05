<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ilinix Intern Tracker') }} - Page Not Found</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <style>
        :root {
            --primary: #199254;
            --secondary: #5ace5a;
            --tertiary: #a0cc36;
            --quaternary: #36cc91;
            --primary-rgb: 25, 146, 84;
            --secondary-rgb: 90, 206, 90;
            --tertiary-rgb: 160, 204, 54;
            --quaternary-rgb: 54, 204, 145;
            --primary-darker: #167f49;
            --secondary-darker: #4db14d;
            --tertiary-darker: #8bb330;
            --quaternary-darker: #2eb580;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --white: #ffffff;
            --error: #ef4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            color: var(--gray-900);
            background-color: var(--gray-50);
            min-height: 100vh;
            line-height: 1.5;
        }

        a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        a:hover {
            color: var(--primary-darker);
            text-decoration: underline;
        }

        /* Background shapes */
        .bg-shape {
            position: fixed;
            z-index: -1;
            border-radius: 50%;
        }

        .shape-1 {
            top: -15%;
            left: -10%;
            width: 40%;
            height: 50%;
            background: rgba(var(--primary-rgb), 0.1);
            transform: rotate(-20deg);
        }

        .shape-2 {
            bottom: -20%;
            right: -10%;
            width: 60%;
            height: 60%;
            background: rgba(var(--quaternary-rgb), 0.1);
        }

        .shape-3 {
            top: 10%;
            right: 20%;
            width: 20%;
            height: 20%;
            background: rgba(var(--tertiary-rgb), 0.1);
        }

        /* Layout */
        .container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            text-align: center;
        }

        .logo-container {
            margin-bottom: 2.5rem;
        }

       
        .logo {
            height: 2rem;
            width: auto;
        }

        .error-card {
            width: 100%;
            max-width: 550px;
            background-color: var(--white);
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 3rem 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .error-code {
            font-size: 6rem;
            font-weight: 700;
            line-height: 1;
            color: var(--primary);
            margin-bottom: 1.5rem;
        }

        .error-title {
            font-size: 1.875rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--gray-800);
        }

        .error-message {
            font-size: 1.125rem;
            color: var(--gray-600);
            margin-bottom: 2rem;
            max-width: 400px;
        }

        .button {
            display: inline-block;
            padding: 0.75rem 2rem;
            background-color: var(--primary);
            color: var(--white);
            border: none;
            border-radius: 0.375rem;
            font-size: 1rem;
            font-weight: 600;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .button:hover {
            background-color: var(--primary-darker);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(var(--primary-rgb), 0.2);
            text-decoration: none;
            color: var(--white);
        }

        .footer {
            margin-top: 2.5rem;
            text-align: center;
            font-size: 0.875rem;
            color: var(--gray-500);
        }

        /* Error page specific */
        .error-illustration {
            width: 250px;
            height: 200px;
            margin-bottom: 2rem;
        }

        .search-box {
            margin: 1.5rem 0;
            position: relative;
            width: 100%;
            max-width: 350px;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem;
            padding-right: 3rem;
            border: 1px solid var(--gray-300);
            border-radius: 0.375rem;
            font-size: 0.875rem;
            outline: none;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .search-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.2);
        }

        .search-button {
            position: absolute;
            right: 0.5rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--primary);
            cursor: pointer;
            padding: 0.25rem;
        }

        .links-list {
            margin: 1.5rem 0;
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        @media (max-width: 640px) {
            .error-code {
                font-size: 5rem;
            }
            
            .error-title {
                font-size: 1.5rem;
            }
            
            .error-message {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>
    <div class="bg-shape shape-3"></div>

    <div class="container">
        <div class="logo-container">
            <a href="/">
                <img src="{{ asset('dashboard-assets/img/logo/ilinix-logo.png') }}" alt="Ilinix" class="logo">
            </a>
        </div>

        <div class="error-card">
            <svg class="error-illustration" viewBox="0 0 250 200" xmlns="http://www.w3.org/2000/svg">
                <!-- Magnifying glass with question mark -->
                <circle cx="100" cy="90" r="60" fill="#f3f4f6" stroke="#167f49" stroke-width="4"/>
                <circle cx="100" cy="90" r="40" fill="#ffffff" stroke="#167f49" stroke-width="2"/>
                <rect x="142" y="130" width="25" height="80" rx="10" transform="rotate(-45 142 130)" fill="#167f49"/>
                
                <!-- Question mark -->
                <path d="M100 70c0-5.5 4.5-10 10-10s10 4.5 10 10c0 4-3 7-7 9-2 1-3 3-3 5v6" stroke="#167f49" stroke-width="6" stroke-linecap="round" fill="none"/>
                <circle cx="110" cy="105" r="5" fill="#167f49"/>
                
                <!-- Folders in background -->
                <rect x="170" y="40" width="60" height="45" rx="5" fill="#5ace5a" opacity="0.6"/>
                <rect x="180" y="30" width="60" height="45" rx="5" fill="#36cc91" opacity="0.6"/>
                <rect x="190" y="20" width="60" height="45" rx="5" fill="#a0cc36" opacity="0.6"/>
                
                <!-- Small dots -->
                <circle cx="30" cy="40" r="5" fill="#199254" opacity="0.6"/>
                <circle cx="50" cy="30" r="3" fill="#199254" opacity="0.6"/>
                <circle cx="45" cy="55" r="4" fill="#199254" opacity="0.6"/>
                <circle cx="190" cy="140" r="6" fill="#199254" opacity="0.6"/>
                <circle cx="210" cy="150" r="4" fill="#199254" opacity="0.6"/>
                <circle cx="205" cy="130" r="5" fill="#199254" opacity="0.6"/>
            </svg>

            <h1 class="error-code">404</h1>
            <h2 class="error-title">Page Not Found</h2>
            <p class="error-message">The page you are looking for doesn't exist or has been moved.</p>
            
            <a href="/" class="button">Back to Home</a>

            <ul class="links-list">
                <li><a href="{{ route('login') }}">Sign In</a></li>
                <li><a href="{{ route('register') }}">Register</a></li>
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            </ul>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Ilinix Company. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
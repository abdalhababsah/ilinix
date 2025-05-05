<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ilinix Intern Tracker') }} - Server Error</title>

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
            --error-darker: #b91c1c;
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
            color: var(--error);
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

        .links-list {
            margin: 1.5rem 0;
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .report-button {
            display: inline-block;
            padding: 0.75rem 2rem;
            background-color: var(--white);
            color: var(--error-darker);
            border: 1px solid var(--error);
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 1rem;
        }

        .report-button:hover {
            background-color: rgba(239, 68, 68, 0.1);
            text-decoration: none;
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

        /* Animation for gear rotation */
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .spin {
            animation: spin 20s linear infinite;
            transform-origin: center;
        }

        .spin-reverse {
            animation: spin 15s linear infinite reverse;
            transform-origin: center;
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
                <!-- Gear elements with animation -->
                <g class="spin">
                    <circle cx="125" cy="100" r="40" fill="#f3f4f6" stroke="#ef4444" stroke-width="3"/>
                    <path d="M125 60 L125 50 L135 45 L145 50 L145 60" fill="#f3f4f6" stroke="#ef4444" stroke-width="3"/>
                    <path d="M125 140 L125 150 L135 155 L145 150 L145 140" fill="#f3f4f6" stroke="#ef4444" stroke-width="3"/>
                    <path d="M85 100 L75 100 L70 110 L75 120 L85 120" fill="#f3f4f6" stroke="#ef4444" stroke-width="3"/>
                    <path d="M165 100 L175 100 L180 110 L175 120 L165 120" fill="#f3f4f6" stroke="#ef4444" stroke-width="3"/>
                    
                    <path d="M98 73 L90 65 L90 55 L100 50 L110 57" fill="#f3f4f6" stroke="#ef4444" stroke-width="3"/>
                    <path d="M152 127 L160 135 L160 145 L150 150 L140 143" fill="#f3f4f6" stroke="#ef4444" stroke-width="3"/>
                    <path d="M98 127 L90 135 L80 135 L75 125 L82 115" fill="#f3f4f6" stroke="#ef4444" stroke-width="3"/>
                    <path d="M152 73 L160 65 L170 65 L175 75 L168 85" fill="#f3f4f6" stroke="#ef4444" stroke-width="3"/>
                </g>
                
                <circle cx="125" cy="100" r="15" fill="#ffffff" stroke="#ef4444" stroke-width="2"/>
                
                <!-- Small gear in the top right -->
                <g class="spin-reverse" transform="translate(180, 50)">
                    <circle cx="0" cy="0" r="20" fill="#f3f4f6" stroke="#ef4444" stroke-width="2"/>
                    <path d="M0 -20 L0 -25 L5 -27 L10 -25 L10 -20" fill="#f3f4f6" stroke="#ef4444" stroke-width="2"/>
                    <path d="M0 20 L0 25 L5 27 L10 25 L10 20" fill="#f3f4f6" stroke="#ef4444" stroke-width="2"/>
                    <path d="M-20 0 L-25 0 L-27 5 L-25 10 L-20 10" fill="#f3f4f6" stroke="#ef4444" stroke-width="2"/>
                    <path d="M20 0 L25 0 L27 5 L25 10 L20 10" fill="#f3f4f6" stroke="#ef4444" stroke-width="2"/>
                    <circle cx="0" cy="0" r="7" fill="#ffffff" stroke="#ef4444" stroke-width="1.5"/>
                </g>
                
                <!-- Small gear in the bottom left -->
                <g class="spin" transform="translate(60, 140)">
                    <circle cx="0" cy="0" r="15" fill="#f3f4f6" stroke="#ef4444" stroke-width="2"/>
                    <path d="M0 -15 L0 -20 L3 -22 L6 -20 L6 -15" fill="#f3f4f6" stroke="#ef4444" stroke-width="2"/>
                    <path d="M0 15 L0 20 L3 22 L6 20 L6 15" fill="#f3f4f6" stroke="#ef4444" stroke-width="2"/>
                    <path d="M-15 0 L-20 0 L-22 3 L-20 6 L-15 6" fill="#f3f4f6" stroke="#ef4444" stroke-width="2"/>
                    <path d="M15 0 L20 0 L22 3 L20 6 L15 6" fill="#f3f4f6" stroke="#ef4444" stroke-width="2"/>
                    <circle cx="0" cy="0" r="5" fill="#ffffff" stroke="#ef4444" stroke-width="1.5"/>
                </g>
                
                <!-- Warning symbols -->
                <path d="M35 60 L45 40 L55 60 Z" stroke="#ef4444" stroke-width="2" fill="none"/>
                <circle cx="45" cy="55" r="1.5" fill="#ef4444"/>
                <rect x="44" y="45" width="2" height="7" fill="#ef4444"/>
                
                <path d="M195 160 L205 140 L215 160 Z" stroke="#ef4444" stroke-width="2" fill="none"/>
                <circle cx="205" cy="155" r="1.5" fill="#ef4444"/>
                <rect x="204" y="145" width="2" height="7" fill="#ef4444"/>
                
                <!-- Small dots -->
                <circle cx="30" cy="30" r="4" fill="#ef4444" opacity="0.3"/>
                <circle cx="45" cy="20" r="3" fill="#ef4444" opacity="0.3"/>
                <circle cx="40" cy="40" r="3.5" fill="#ef4444" opacity="0.3"/>
                <circle cx="200" cy="30" r="5" fill="#ef4444" opacity="0.3"/>
                <circle cx="220" cy="40" r="3.5" fill="#ef4444" opacity="0.3"/>
                <circle cx="215" cy="20" r="4" fill="#ef4444" opacity="0.3"/>
            </svg>

            <h1 class="error-code">500</h1>
            <h2 class="error-title">Server Error</h2>
            <p class="error-message">Our system encountered an unexpected error. Our technical team has been notified and is working to fix the issue.</p>
            
            <a href="/" class="button">Back to Home</a>
            <a href="/contact" class="report-button">Report This Problem</a>

            <ul class="links-list">
                <li><a href="/">Try Again</a></li>
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><a href="/help">Help Center</a></li>
            </ul>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Ilinix Company. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
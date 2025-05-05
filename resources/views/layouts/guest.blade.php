<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ilinix Intern Tracker') }}</title>

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
            color: inherit;
            text-decoration: none;
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
        }

        .logo-container {
            margin: 1.5rem 0 2rem 0;
        }

        .logo {
            height: 2rem;
            width: auto;
        }

        .auth-card {
            width: 100%;
            max-width: 900px;
            display: flex;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            overflow: hidden;
        }

        .auth-sidebar {
            display: none; /* Hidden on mobile */
            background: linear-gradient(135deg, var(--primary), var(--quaternary));
            color: var(--white);
            padding: 2rem;
            position: relative;
        }

        .auth-sidebar::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200' width='100%25' height='100%25' opacity='0.06'%3E%3Cpath fill='%23FFFFFF' d='M-19,55.1c17.8,3.5,34.7,9.9,54.5,9.5c14.8-0.3,27.8-7.7,40.1-14.2c17-8.8,31.9-19.8,52.2-22.5c17.5-2.3,33.2,5.8,47.5,14.4c14.9,8.9,29.3,18.7,47.9,21.4c20.5,3,40.7-5.4,60.2-9.7c22-4.9,43.7-4.5,65.3,1.6'/%3E%3C/svg%3E") center/cover no-repeat;
            pointer-events: none;
        }

        .auth-sidebar-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .auth-sidebar-text {
            margin-bottom: 1.5rem;
            opacity: 0.8;
        }

        .illustration-container {
            width: 80%;
            margin: 0 auto;
        }

        .auth-content {
            width: 100%;
            padding: 2rem;
            background-color: var(--white);
        }

        .footer {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.875rem;
            color: var(--gray-500);
        }

        /* Form Elements */
        .text-primary {
            color: var(--primary);
        }

        .form-group {
            margin-bottom: 0.5rem;
        }

        .form-label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--gray-700);
        }

        .form-input-container {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            padding-left: 2.5rem;
            border: 1px solid var(--gray-300);
            border-radius: 0.375rem;
            font-size: 0.875rem;
            line-height: 1.5;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-input-prefix {
            width: 100% !important;
            flex: 0 0 80%;
            padding: 0.75rem 1rem;
            padding-left: 2.5rem;
            border: 1px solid var(--gray-300);
            border-right: none;
            border-top-left-radius: 0.375rem;
            border-bottom-left-radius: 0.375rem;
            font-size: 0.875rem;
        }

        .form-input-suffix {
          
            flex: 0 0 20%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.6rem 0.5rem;
            background-color: var(--gray-100);
            border: 1px solid var(--gray-300);
            border-left: none;
            border-top-right-radius: 0.375rem;
            border-bottom-right-radius: 0.375rem;
            color: var(--gray-500);
            font-size: 0.875rem;
            white-space: nowrap;
        }

        .form-input-password {
            padding-right: 2.5rem;
        }

        .form-input:focus, .form-input-prefix:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.2);
        }

        .form-input-icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 1.25rem;
            height: 1.25rem;
            z-index: 1;
        }

        .icon-left {
            left: 0.75rem;
            color: var(--gray-400);
            pointer-events: none;
        }

        .icon-right {
            right: 0.75rem;
            color: var(--gray-400);
            cursor: pointer;
        }

        .form-error {
            color: var(--error);
            font-size: 0.75rem;
            margin-top: 0.5rem;
        }

        .form-checkbox-container {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .form-checkbox {
            width: 1rem;
            height: 1rem;
            margin-right: 0.5rem;
            border-radius: 0.25rem;
            border: 1px solid var(--gray-300);
            accent-color: var(--primary);
        }

        .form-checkbox-label {
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .form-helper {
            font-size: 0.75rem;
            color: var(--gray-500);
            margin-top: 0.25rem;
        }

        .button {
            display: block;
            width: 100%;
            padding: 0.75rem 1rem;
            background-color: var(--primary);
            color: var(--white);
            border: none;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .button:hover {
            background-color: var(--primary-darker);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(var(--primary-rgb), 0.2);
        }

        .form-footer {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .form-footer a {
            color: var(--primary);
            font-weight: 500;
        }

        .form-footer a:hover {
            color: var(--primary-darker);
        }

        .form-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--primary);
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .form-subtitle {
            font-size: 1rem;
            color: var(--gray-600);
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .form-row {
            display: flex;
            gap: 1rem;
        }

        .form-flex {
            display: flex;
        }

        .form-link {
            font-size: 0.875rem;
            color: var(--primary);
            text-decoration: none;
        }

        .form-link:hover {
            color: var(--primary-darker);
            text-decoration: underline;
        }

        .justify-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .alert {
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
        }

        .alert-success {
            background-color: rgba(var(--secondary-rgb), 0.1);
            color: var(--secondary-darker);
            border: 1px solid rgba(var(--secondary-rgb), 0.2);
        }

        .alert-error {
            background-color: rgba(239, 68, 68, 0.1);
            color: #b91c1c;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        /* Media Queries */
        @media (min-width: 640px) {
            .auth-sidebar {
                display: block;
                width: 41.666667%; /* 5/12 */
            }

            .auth-content {
                width: 58.333333%; /* 7/12 */
            }
        }

        @media (max-width: 639px) {
            .auth-card {
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {
            .form-row {
                flex-direction: column;
                gap: 1.5rem;
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

        <div class="auth-card">
            <div class="auth-sidebar">
                <h2 class="auth-sidebar-title">Ilinix Intern Tracker</h2>
                <p class="auth-sidebar-text">Streamline your internship management process with our comprehensive tracking platform.</p>
                <div class="illustration-container">
                    <svg viewBox="0 0 350 250" xmlns="http://www.w3.org/2000/svg" width="100%">
                        <!-- Dashboard background -->
                        <rect x="20" y="20" width="310" height="210" rx="10" fill="white" opacity="0.9"/>
                        
                        <!-- Header -->
                        <rect x="20" y="20" width="310" height="40" rx="10" fill="#167f49"/>
                        <circle cx="45" cy="40" r="10" fill="white" opacity="0.7"/>
                        <rect x="65" y="35" width="80" height="10" rx="2" fill="white" opacity="0.7"/>
                        <rect x="250" y="35" width="60" height="10" rx="2" fill="white" opacity="0.7"/>
                        
                        <!-- Sidebar -->
                        <rect x="20" y="60" width="70" height="170" fill="#f3f4f6"/>
                        <rect x="35" y="80" width="40" height="6" rx="2" fill="#167f49"/>
                        <rect x="35" y="100" width="40" height="6" rx="2" fill="#167f49" opacity="0.7"/>
                        <rect x="35" y="120" width="40" height="6" rx="2" fill="#167f49" opacity="0.7"/>
                        <rect x="35" y="140" width="40" height="6" rx="2" fill="#167f49" opacity="0.7"/>
                        <rect x="35" y="160" width="40" height="6" rx="2" fill="#167f49" opacity="0.7"/>
                        
                        <!-- Main content area -->
                        <rect x="105" y="70" width="210" height="60" rx="5" fill="#f3f4f6"/>
                        <rect x="115" y="80" width="120" height="10" rx="2" fill="#167f49"/>
                        <rect x="115" y="100" width="190" height="6" rx="2" fill="#167f49" opacity="0.5"/>
                        <rect x="115" y="110" width="150" height="6" rx="2" fill="#167f49" opacity="0.5"/>
                        
                        <!-- Stats boxes -->
                        <rect x="105" y="140" width="100" height="80" rx="5" fill="#f3f4f6"/>
                        <rect x="115" y="150" width="60" height="8" rx="2" fill="#167f49"/>
                        <text x="155" y="180" font-family="Arial" font-size="24" fill="#167f49" text-anchor="middle" font-weight="bold">42</text>
                        <rect x="115" y="200" width="80" height="6" rx="2" fill="#167f49" opacity="0.5"/>
                        
                        <rect x="215" y="140" width="100" height="80" rx="5" fill="#f3f4f6"/>
                        <rect x="225" y="150" width="60" height="8" rx="2" fill="#5ace5a"/>
                        <text x="265" y="180" font-family="Arial" font-size="24" fill="#5ace5a" text-anchor="middle" font-weight="bold">18</text>
                        <rect x="225" y="200" width="80" height="6" rx="2" fill="#5ace5a" opacity="0.5"/>
                        
                        <!-- Decorative elements -->
                        <circle cx="330" cy="40" r="6" fill="white" opacity="0.7"/>
                        <circle cx="310" cy="40" r="6" fill="white" opacity="0.7"/>
                    </svg>
                </div>
            </div>

            <div class="auth-content">
                {{ $slot }}
            </div>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Ilinix Company. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
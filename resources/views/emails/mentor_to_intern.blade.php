<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subjectLine }}</title>
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
            --light-bg: #f9fafb;
            --border-color: #e2e8f0;
            --text-dark: #333333;
            --text-muted: #6b7280;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background-color: #f4f7f9;
            margin: 0;
            padding: 0;
        }
        
        .email-wrapper {
            width: 100%;
            max-width: 650px;
            margin: 0 auto;
            background-color: white;
        }
        
        .email-header {
            background: linear-gradient(135deg, var(--primary), var(--quaternary));
            padding: 25px 0;
            text-align: center;
            position: relative;
        }
        
        .pattern-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.2;
        }
        
        .logo {
            max-height: 60px;
            margin-bottom: 10px;
        }
        
        .email-body {
            padding: 30px;
            background-color: white;
        }
        
        .greeting {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 20px;
            color: var(--text-dark);
        }
        
        .message {
            font-size: 15px;
            line-height: 1.7;
            color: var(--text-dark);
            margin-bottom: 25px;
        }
        
        .message p {
            margin-bottom: 15px;
        }
        
        .signature {
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid #edf2f7;
        }
        
        .signature-name {
            font-weight: 600;
            margin-top: 5px;
        }
        
        .email-footer {
            background-color: var(--light-bg);
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: var(--text-muted);
            border-top: 1px solid var(--border-color);
        }
        
        .footer-links {
            margin: 15px 0;
        }
        
        .footer-links a {
            color: var(--primary);
            text-decoration: none;
            margin: 0 10px;
        }
        
        .footer-links a:hover {
            text-decoration: underline;
        }
        
        @media screen and (max-width: 600px) {
            .email-body {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-header">
            <div class="pattern-overlay"></div>
            <img src="{{ asset('dashboard-assets/img/logo/ilinix-logo.png') }}" alt="{{ config('app.name') }}" class="logo">
        </div>
        
        <div class="email-body">
            <div class="greeting">
                Hi {{ $intern->first_name }},
            </div>
            
            <div class="message">
                {!! nl2br(e($messageBody)) !!}
            </div>
            
            <div class="signature">
                <p>Best regards,</p>
                <p class="signature-name">{{ $mentor->first_name }} {{ $mentor->last_name }}</p>
                <p class="signature-title">Your Mentor</p>
            </div>
        </div>
        
        <div class="email-footer">
            <div class="footer-links">
                <a href="{{ route('intern.dashboard') }}">Dashboard</a>
            </div>
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>This email was sent to you as part of the {{ config('app.name') }} Internship Program.</p>
        </div>
    </div>
</body>
</html>
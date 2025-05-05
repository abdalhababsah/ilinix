<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Mentee Assignment</title>
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
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background-color: #f4f7f9;
            margin: 0;
            padding: 0;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
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
            position: relative;
            z-index: 1;
        }
        
        .logo img {
            height: 45px;
            margin-bottom: 10px;
        }
        
        .header-title {
            color: white;
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 5px;
            position: relative;
            z-index: 1;
        }
        
        .header-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            position: relative;
            z-index: 1;
        }
        
        .email-body {
            padding: 30px;
        }
        
        .greeting {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 20px;
        }
        
        .mentee-card {
            background-color: rgba(var(--primary-rgb), 0.05);
            border-left: 4px solid var(--primary);
            padding: 20px;
            border-radius: 4px;
            margin: 25px 0;
        }
        
        .mentee-card-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--primary-darker);
            margin-bottom: 15px;
        }
        
        .mentee-card-name {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .mentee-card-info {
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 5px;
        }
        
        .action-button {
            display: inline-block;
            background-color: var(--primary);
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 4px;
            font-weight: 500;
            margin-top: 25px;
            transition: background-color 0.2s;
        }
        
        .action-button:hover {
            background-color: var(--primary-darker);
        }
        
        .message {
            font-size: 15px;
            line-height: 1.7;
        }
        
        .signature {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }
        
        .signature-team {
            font-weight: 600;
            margin-top: 5px;
        }
        
        .steps-container {
            margin: 25px 0;
        }
        
        .steps-title {
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--primary-darker);
        }
        
        .steps-list {
            list-style-type: none;
        }
        
        .step-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        
        .step-number {
            background-color: var(--primary);
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            margin-right: 12px;
            flex-shrink: 0;
        }
        
        .step-content {
            font-size: 14px;
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
            margin: 10px 0;
        }
        
        .footer-links a {
            color: var(--primary);
            text-decoration: none;
            margin: 0 10px;
        }
        
        .button-container {
            text-align: center;
            margin: 25px 0 15px;
        }
        
        @media screen and (max-width: 600px) {
            .email-body {
                padding: 20px;
            }
            
            .mentee-card {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <div class="pattern-overlay"></div>
            <div class="logo">
                <img src="{{ asset('dashboard-assets/img/logo/ilinix-logo.png') }}" alt="Ilinix Logo">
            </div>
            <div class="header-title">New Mentee Assignment</div>
            <div class="header-subtitle">Mentorship Program</div>
        </div>
        
        <div class="email-body">
            <div class="greeting">
                Hi {{ $intern->mentor->first_name }},
            </div>
            
            <div class="message">
                <p>You've just been assigned as the mentor for:</p>
                
                <div class="mentee-card">
                    <div class="mentee-card-title">Your New Mentee</div>
                    <div class="mentee-card-name">
                        <strong>{{ $intern->first_name }} {{ $intern->last_name }}</strong>
                    </div>
                    <!-- Optional info fields - can be added dynamically when data is available -->
                    <!-- <div class="mentee-card-info">Program: Software Development</div> -->
                    <!-- <div class="mentee-card-info">Start Date: {{ date('F j, Y') }}</div> -->
                </div>
                
                <p>Log in to your dashboard to review their profile and get started on your mentorship journey.</p>
                
                <div class="steps-container">
                    <div class="steps-title">Next Steps:</div>
                    <ul class="steps-list">
                        <li class="step-item">
                            <div class="step-number">1</div>
                            <div class="step-content">Review your mentee's profile and background</div>
                        </li>
                        <li class="step-item">
                            <div class="step-number">2</div>
                            <div class="step-content">Schedule an initial meeting within the next week</div>
                        </li>
                        <li class="step-item">
                            <div class="step-number">3</div>
                            <div class="step-content">Prepare a preliminary development plan</div>
                        </li>
                    </ul>
                </div>
                
                <div class="button-container">
                    <a href="#" class="action-button">Go to Dashboard</a>
                </div>
            </div>
            
            <div class="signature">
                <p>Thanks,</p>
                <p class="signature-team">Your Admin Team</p>
            </div>
        </div>
        
        <div class="email-footer">
            <div class="footer-links">
                <a href="#">Dashboard</a>
            </div>
            <p>© {{ date('Y') }} Ilinix. All rights reserved.</p>
            <p>This is an automated message from the Ilinix Intership Program.</p>
        </div>
    </div>
</body>
</html>
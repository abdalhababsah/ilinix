<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentoring Session Scheduled</title>
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
        
        .action-button {
            display: inline-block;
            background-color: var(--primary);
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: 500;
            margin: 15px 0;
        }
        
        .action-button:hover {
            background-color: var(--primary-darker);
        }
        
        .button-container {
            text-align: center;
            margin: 25px 0;
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
        
        .highlight-box {
            background-color: rgba(var(--tertiary-rgb), 0.1);
            border-left: 3px solid var(--tertiary);
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        
        .highlight-title {
            font-weight: 600;
            color: var(--tertiary-darker);
            margin-bottom: 8px;
        }
        
        .quote {
            border-left: 3px solid var(--secondary);
            padding-left: 15px;
            margin: 15px 0;
            font-style: italic;
            color: var(--text-dark);
        }
        
        .session-details {
            background-color: var(--light-bg);
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .session-details-title {
            font-weight: 600;
            color: var(--primary);
            font-size: 17px;
            margin-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 8px;
        }
        
        .session-row {
            display: flex;
            margin-bottom: 12px;
        }
        
        .session-label {
            width: 120px;
            font-weight: 600;
            color: var(--text-dark);
        }
        
        .session-value {
            flex: 1;
            color: var(--text-dark);
        }
        
        .agenda-section {
            margin: 20px 0;
        }
        
        .agenda-title {
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 10px;
            font-size: 17px;
        }
        
        .agenda-content {
            background-color: var(--light-bg);
            border-radius: 6px;
            padding: 15px;
            white-space: pre-line;
        }
        
        .meeting-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            word-break: break-all;
        }
        
        .meeting-link:hover {
            text-decoration: underline;
        }
        
        .meeting-link-box {
            background-color: rgba(var(--primary-rgb), 0.05);
            border: 1px solid rgba(var(--primary-rgb), 0.1);
            border-radius: 6px;
            padding: 12px;
            margin-top: 5px;
        }
        
        @media screen and (max-width: 600px) {
            .email-body {
                padding: 20px;
            }
            
            .session-row {
                flex-direction: column;
            }
            
            .session-label {
                width: 100%;
                margin-bottom: 4px;
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
                <p>A mentoring session has been scheduled for you with <strong>{{ $mentor->first_name }} {{ $mentor->last_name }}</strong>.</p>
                
                <div class="session-details">
                    <div class="session-details-title">Session Details</div>
                    
                    <div class="session-row">
                        <div class="session-label">Title:</div>
                        <div class="session-value">{{ $session->title }}</div>
                    </div>
                    
                    <div class="session-row">
                        <div class="session-label">Date & Time:</div>
                        <div class="session-value">{{ $sessionDateTime }}</div>
                    </div>
                    
                    <div class="session-row">
                        <div class="session-label">Duration:</div>
                        <div class="session-value">{{ $session->duration }} minutes</div>
                    </div>
                    
                    @if($session->meeting_link)
                    <div class="session-row">
                        <div class="session-label">Meeting Link:</div>
                        <div class="session-value">
                            <div class="meeting-link-box">
                                <a href="{{ $session->meeting_link }}" target="_blank" class="meeting-link">
                                    {{ $session->meeting_link }}
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                
                @if($session->agenda)
                <div class="agenda-section">
                    <div class="agenda-title">Agenda</div>
                    <div class="agenda-content">
                        {{ $session->agenda }}
                    </div>
                </div>
                @endif
                
                <p>You can add this session to your calendar using the attached calendar file (.ics).</p>
                
                <div class="highlight-box">
                    <div class="highlight-title">Important Reminder</div>
                    <p>Please make sure to be prepared and on time for the session. If you need to reschedule, please contact your mentor as soon as possible.</p>
                </div>
                
                <div class="button-container">
                    <a href="{{ route('intern.sessions.show', $session->id) }}" class="action-button">View Session Details</a>
                </div>
            </div>
            
            <div class="signature">
                <p>Best regards,</p>
                <p class="signature-name">{{ config('app.name') }} Team</p>
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
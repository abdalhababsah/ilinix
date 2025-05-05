<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ilinix Message Notification</title>
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
            --light-bg: #f5f7fa;
            --border-color: #e2e8f0;
            --text-dark: #334155;
            --text-muted: #64748b;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background-color: var(--light-bg);
            padding: 20px;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 0 10px 15px rgba(0, 0, 0, 0.03);
        }
        
        .header {
            background: linear-gradient(135deg, var(--primary), var(--quaternary));
            color: white;
            padding: 25px 30px;
            text-align: center;
        }
        
        .logo {
            margin-bottom: 15px;
        }
        
        .logo img {
            height: 50px;
            width: auto;
        }
        
        .header h1 {
            font-size: 22px;
            font-weight: 600;
            margin: 0;
            letter-spacing: 0.5px;
        }
        
        .notification-details {
            background-color: #f9fafb;
            border-bottom: 1px solid var(--border-color);
            padding: 15px 30px;
            font-size: 14px;
            color: var(--text-muted);
        }
        
        .notification-details p {
            margin: 5px 0;
        }
        
        .notification-details strong {
            color: var(--text-dark);
        }
        
        .content {
            padding: 30px;
        }
        
        .content p {
            margin-bottom: 20px;
            font-size: 15px;
        }
        
        .message-box {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 25px;
            margin: 25px 0;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
            position: relative;
        }
        
        .message-box::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(to bottom, var(--primary), var(--quaternary));
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }
        
        .message-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--primary);
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 10px;
        }
        
        .message-content {
            font-size: 14px;
            color: var(--text-dark);
            line-height: 1.6;
        }
        
        .notification-end {
            font-size: 13px;
            font-style: italic;
            color: var(--text-muted);
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px dashed var(--border-color);
        }
        
        .footer {
            background-color: #f9fafb;
            border-top: 1px solid var(--border-color);
            padding: 20px 30px;
            font-size: 12px;
            color: var(--text-muted);
            text-align: center;
        }
        
        .footer p {
            margin: 5px 0;
        }
        
        .footer a {
            color: var(--primary);
            text-decoration: none;
        }
        
        .social-links {
            margin-top: 15px;
        }
        
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: var(--text-muted);
            text-decoration: none;
        }
        
        .button {
            display: inline-block;
            background-color: var(--primary);
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 500;
            margin-top: 10px;
            transition: background-color 0.2s;
        }
        
        .button:hover {
            background-color: var(--primary-darker);
        }
        
        .pattern-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.3;
            z-index: 0;
        }
        
        @media screen and (max-width: 550px) {
            body {
                padding: 10px;
            }
            
            .header, .content, .footer, .notification-details {
                padding: 15px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="pattern-background"></div>
            <div class="logo">
                <img src="{{ asset('dashboard-assets/img/logo/ilinix-logo.png') }}" alt="Ilinix logo" />
            </div>
            <h1>Message Notification</h1>
        </div>
        
        <div class="notification-details">
            <p><strong>Recipient:</strong> {{ $recipient }}</p>
            <p><strong>Date:</strong> {{ date('F j, Y') }}</p>
            <p><strong>Time:</strong> {{ date('h:i A') }}</p>
        </div>
        
        <div class="content">
            <p>Hello,</p>
            
            <p>You requested to receive a copy of the message that was sent to <strong>{{ $recipient }}</strong>. Please find the complete message content below.</p>
            
            <div class="message-box">
                <div class="message-title">Message Content</div>
                <div class="message-content">
                    {{ $messageBody }}
                </div>
            </div>
            
            <p>If you have any questions about this message or need to take any further action, please use the button below to access your Ilinix dashboard.</p>
            
            <div style="text-align: center;">
                <a href="#" class="button">Go to Dashboard</a>
            </div>
            
            <div class="notification-end">— End of copy —</div>
        </div>
        
        <div class="footer">
            <p>This is an automated notification from the Ilinix platform. Please do not reply directly to this email.</p>
            <p>&copy; {{ date('Y') }} Ilinix. All rights reserved.</p>

        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentor Update Notification</title>
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
            margin: 0;
            padding: 0;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 0 10px 15px rgba(0, 0, 0, 0.03);
            border-radius: 8px;
            overflow: hidden;
        }
        
        .email-header {
            background: linear-gradient(135deg, var(--primary), var(--quaternary));
            padding: 25px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
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
        
        .logo-container {
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }
        
        .logo-container img {
            height: 45px;
            width: auto;
        }
        
        .header-title {
            color: white;
            font-size: 20px;
            font-weight: 600;
            position: relative;
            z-index: 1;
        }
        
        .email-body {
            padding: 35px;
            background-color: #ffffff;
        }
        
        .greeting {
            font-size: 18px;
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 15px;
        }
        
        .message-content {
            font-size: 15px;
            line-height: 1.7;
            color: var(--text-dark);
        }
        
        .message-content p {
            margin-bottom: 15px;
        }
        
        .mentor-info {
            background-color: rgba(var(--primary-rgb), 0.05);
            border-left: 3px solid var(--primary);
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        
        .mentor-status {
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--primary-darker);
        }
        
        .mentor-name {
            font-size: 18px;
            color: var(--text-dark);
        }
        
        .action-button {
            display: inline-block;
            background-color: var(--primary);
            color: white;
            text-decoration: none;
            padding: 10px 24px;
            border-radius: 4px;
            font-weight: 500;
            font-size: 15px;
            margin-top: 20px;
            transition: background-color 0.3s;
        }
        
        .action-button:hover {
            background-color: var(--primary-darker);
        }
        
        .signature {
            margin-top: 30px;
            border-top: 1px solid #eaeaea;
            padding-top: 20px;
            color: var(--text-dark);
        }
        
        .signature-team {
            font-weight: 600;
        }
        
        .email-footer {
            background-color: #f7f9fc;
            padding: 20px;
            text-align: center;
            border-top: 1px solid var(--border-color);
        }
        
        .footer-links {
            margin-bottom: 12px;
        }
        
        .footer-links a {
            color: var(--primary);
            text-decoration: none;
            margin: 0 8px;
            font-size: 13px;
        }
        
        .footer-links a:hover {
            text-decoration: underline;
        }
        
        .footer-text {
            color: var(--text-muted);
            font-size: 12px;
            margin-bottom: 6px;
        }
        
        .removed-status {
            color: #f97316; /* Orange for removed */
        }
        
        .changed-status {
            color: var(--primary); /* Green for changed */
        }
        
        @media screen and (max-width: 600px) {
            .email-body {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <div class="pattern-overlay"></div>
            <div class="logo-container">
                <img src="{{ asset('dashboard-assets/img/logo/ilinix-logo.png') }}" alt="Ilinix Logo">
            </div>
            <div class="header-title">Mentor Update</div>
        </div>
        
        <div class="email-body">
            <div class="greeting">Hi {{ $intern->first_name }},</div>
            
            <div class="message-content">
                <p>Your mentor has been <span class="{{ $intern->assigned_mentor_id ? 'changed-status' : 'removed-status' }}">{{ $intern->assigned_mentor_id ? 'changed to' : 'removed' }}</span>.</p>
                
                <div class="mentor-info">
                    <div class="mentor-status">
                        {{ $intern->assigned_mentor_id ? 'Your new mentor is:' : 'Current mentor status:' }}
                    </div>
                    <div class="mentor-name">
                        <strong>
                            {{ $intern->mentor 
                                ? ($intern->mentor->first_name . ' ' . $intern->mentor->last_name) 
                                : 'None' }}
                        </strong>
                    </div>
                </div>
                
                <p>Log in to your intern dashboard if you have any questions about this change.</p>
                
                <a href="#" class="action-button">Login to Dashboard</a>
                
                <div class="signature">
                    <p>Best,</p>
                    <p class="signature-team">Your Admin Team</p>
                    <p>Ilinix Intern Program</p>
                </div>
            </div>
        </div>
        
        <div class="email-footer">
            <div class="footer-links">
                <a href="#">Dashboard</a>
                <a href="#">Help Center</a>
                <a href="#">Contact Support</a>
            </div>
            
            <p class="footer-text">© {{ date('Y') }} Ilinix. All rights reserved.</p>
            <p class="footer-text">This is an automated message from the Ilinix Intern Platform.</p>
        </div>
    </div>
</body>
</html>
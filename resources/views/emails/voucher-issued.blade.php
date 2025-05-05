<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>You Have Received a New Voucher</title>
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
            max-width: 650px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        
        .email-header {
            background: linear-gradient(135deg, var(--primary), var(--quaternary));
            padding: 30px 0;
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
            margin-bottom: 15px;
        }
        
        .logo-container img {
            height: 55px;
            width: auto;
        }
        
        .email-body {
            padding: 40px;
            background-color: #ffffff;
        }
        
        .email-banner {
            height: 6px;
            background: linear-gradient(90deg, var(--primary), var(--quaternary));
            margin-bottom: 25px;
        }
        
        .greeting {
            font-size: 20px;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 20px;
        }
        
        .message-content {
            font-size: 16px;
            line-height: 1.7;
            color: var(--text-dark);
            margin-bottom: 30px;
        }
        
        .message-content p {
            margin-bottom: 15px;
        }
        
        .signature {
            margin-top: 30px;
            border-top: 1px solid #eaeaea;
            padding-top: 20px;
        }
        
        .signature-name {
            font-weight: 600;
            color: var(--text-dark);
        }
        
        .signature-title {
            color: var(--text-muted);
            font-size: 14px;
        }
        
        .cta-container {
            margin: 30px 0;
            text-align: center;
        }
        
        .cta-button {
            display: inline-block;
            background-color: var(--primary);
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            transition: background-color 0.3s;
        }
        
        .cta-button:hover {
            background-color: var(--primary-darker);
        }
        
        .email-footer {
            background-color: #f7f9fc;
            padding: 25px 40px;
            text-align: center;
            border-top: 1px solid var(--border-color);
        }
        
        .footer-links {
            margin-bottom: 15px;
        }
        
        .footer-links a {
            color: var(--primary);
            text-decoration: none;
            margin: 0 10px;
            font-size: 14px;
        }
        
        .footer-links a:hover {
            text-decoration: underline;
        }
        
        .footer-text {
            color: var(--text-muted);
            font-size: 12px;
            margin-bottom: 10px;
        }
        
        .social-icons {
            margin-top: 20px;
        }
        
        .social-icons a {
            display: inline-block;
            margin: 0 10px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 14px;
        }
        
        .voucher-details {
            background-color: rgba(var(--primary-rgb), 0.05);
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
        }
        
        .voucher-code {
            font-family: monospace;
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
            background-color: #f0f7f3;
            border: 1px dashed var(--primary);
            padding: 10px 15px;
            border-radius: 4px;
            text-align: center;
            margin: 15px 0;
        }
        
        .tips-section {
            background-color: rgba(var(--tertiary-rgb), 0.1);
            padding: 20px;
            border-radius: 6px;
            margin-top: 30px;
        }
        
        .tips-title {
            font-weight: 600;
            color: var(--tertiary-darker);
            margin-bottom: 10px;
        }
        
        .tips-list {
            padding-left: 20px;
        }
        
        .tips-list li {
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        @media screen and (max-width: 600px) {
            .email-body {
                padding: 25px;
            }
            
            .email-footer {
                padding: 20px;
            }
            
            .greeting {
                font-size: 18px;
            }
            
            .message-content {
                font-size: 15px;
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
        </div>
        
        <div class="email-body">
            <div class="email-banner"></div>
            
            <div class="greeting">Dear {{ $voucher->issuedTo->first_name }},</div>
            
            <div class="message-content">
                <p>We're pleased to inform you that a new voucher has been issued to your account as part of our Internship Program benefits.</p>
                
                <div class="voucher-details">
                    <p><span class="user-info-label">Certificate Name:</span> {{ $voucher->provider }}</p>
                    <p><span class="user-info-label">Voucher Code:</span></p>
                    <div class="voucher-code">{{ $voucher->code }}</div>
                    <p><span class="user-info-label">Issued Date:</span> {{ $voucher->issued_at->format('F d, Y') }}</p>
                    
                    @if($voucher->notes)
                    <p><span class="user-info-label">Notes:</span> {{ $voucher->notes }}</p>
                    @endif
                </div>
                
                <p>You can use this voucher for learning resources, tools, or services from the specified provider as part of your professional development during your internship period.</p>
                
                <div class="tips-section">
                    <div class="tips-title">Using Your Voucher</div>
                    <ul class="tips-list">
                        <li>Visit the provider's website and select your desired resources</li>
                        <li>Enter the voucher code during checkout</li>
                        <li>The voucher is valid for one-time use only</li>
                        <li>Please use this voucher before its expiration date</li>
                        <li>If you encounter any issues, contact your mentor or the support team</li>
                    </ul>
                </div>
                
                <div class="cta-container">
                    <a href="" class="cta-button">View Your Vouchers</a>
                </div>
            </div>
            
            <div class="signature">
                <p>Best regards,</p>
                <p class="signature-name">Ilinix Mentorship Team</p>
                <p class="signature-title">Ilinix Intern Program</p>
            </div>
        </div>
        
        <div class="email-footer">
            <div class="footer-links">
                <a href="{{ route('intern.dashboard') }}">Dashboard</a>
            </div>
            
            <p class="footer-text">© {{ date('Y') }} Ilinix. All rights reserved.</p>
            <p class="footer-text">This email was sent to you as part of the Ilinix Internship Program.</p>
            
        </div>
    </div>
</body>
</html>
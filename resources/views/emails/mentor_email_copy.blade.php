<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Copy: {{ $subjectLine }}</title>
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
            --text-dark: #333333;
            --text-muted: #64748b;
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
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }
        
        .email-header {
            background: linear-gradient(135deg, var(--primary), var(--quaternary));
            padding: 20px;
            text-align: center;
            color: white;
        }
        
        .header-title {
            font-size: 20px;
            font-weight: 600;
        }
        
        .header-subtitle {
            font-size: 14px;
            opacity: 0.9;
            margin-top: 5px;
        }
        
        .email-body {
            padding: 25px;
        }
        
        .notice {
            background-color: #f7f9fc;
            border-left: 4px solid var(--primary);
            padding: 12px 15px;
            margin-bottom: 20px;
            font-size: 14px;
            border-radius: 0 4px 4px 0;
        }
        
        .notice strong {
            color: var(--primary-darker);
        }
        
        .message-container {
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
            background-color: white;
            position: relative;
        }
        
        .message-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 4px;
            background-color: var(--tertiary);
            border-top-left-radius: 6px;
            border-bottom-left-radius: 6px;
        }
        
        .message-divider {
            height: 1px;
            background: linear-gradient(to right, var(--primary), var(--quaternary));
            margin: 20px 0;
            border: none;
            opacity: 0.5;
        }
        
        .message-content {
            font-size: 14px;
            line-height: 1.6;
            color: var(--text-dark);
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        
        .message-footer {
            text-align: center;
            font-size: 12px;
            color: var(--text-muted);
            font-style: italic;
            margin-top: 20px;
            border-top: 1px dashed var(--border-color);
            padding-top: 15px;
        }
        
        .email-footer {
            background-color: #f7f9fc;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: var(--text-muted);
            border-top: 1px solid var(--border-color);
        }
        
        .email-footer a {
            color: var(--primary);
            text-decoration: none;
        }
        
        @media screen and (max-width: 550px) {
            body {
                padding: 10px;
            }
            
            .email-body {
                padding: 15px;
            }
            
            .message-container {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <div class="header-title">Message Copy</div>
            <div class="header-subtitle">{{ $subjectLine }}</div>
        </div>
        
        <div class="email-body">
            <div class="notice">
                This is a copy of the message sent to <strong>{{ $originalRecipient }}</strong>
            </div>
            
            <hr class="message-divider">
            
            <div class="message-container">
                <div class="message-content">
                    {!! nl2br(e($messageBody)) !!}
                </div>
            </div>
            
            <hr class="message-divider">
            
            <div class="message-footer">
                — End of copy —
            </div>
        </div>
        
        <div class="email-footer">
            <p>© {{ date('Y') }} Ilinix. This is an automated message.</p>
            <p><a href="#">Privacy Policy</a> • <a href="#">Contact Support</a></p>
        </div>
    </div>
</body>
</html>
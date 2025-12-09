<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification Code - SRIS</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #1f2937 0%, #1e3a8a 50%, #1f2937 100%);
            min-height: 100vh;
            color: #ffffff;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
        }
        .logo {
            font-size: 32px;
            font-weight: 800;
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
            text-shadow: 0 0 30px rgba(96, 165, 250, 0.5);
        }
        .subtitle {
            color: #d1d5db;
            font-size: 16px;
            font-weight: 300;
        }
        .welcome-title {
            font-size: 28px;
            font-weight: 700;
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            text-align: center;
            margin: 30px 0 20px 0;
        }
        .verification-section {
            text-align: center;
            margin: 40px 0;
            padding: 30px;
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
            border-radius: 16px;
            color: white;
            box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
        }
        .verification-code {
            font-size: 42px;
            font-weight: 900;
            letter-spacing: 12px;
            margin: 20px 0;
            padding: 25px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        .code-label {
            font-size: 18px;
            margin-bottom: 10px;
            font-weight: 600;
            opacity: 0.9;
        }
        .expiry-notice {
            font-size: 14px;
            margin-top: 15px;
            opacity: 0.8;
        }
        .instructions {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            padding: 25px;
            border-radius: 16px;
            margin: 30px 0;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .instructions h3 {
            color: #60a5fa;
            margin-top: 0;
            font-size: 18px;
            font-weight: 700;
        }
        .instructions ol {
            margin: 15px 0;
            padding-left: 20px;
            color: #e5e7eb;
        }
        .instructions li {
            margin: 10px 0;
            font-size: 15px;
        }
        .warning {
            background: rgba(251, 191, 36, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(251, 191, 36, 0.3);
            border-radius: 16px;
            padding: 20px;
            margin: 25px 0;
        }
        .warning-icon {
            color: #fbbf24;
            font-size: 18px;
            margin-right: 8px;
        }
        .warning-text {
            color: #fef3c7;
            font-size: 14px;
            margin: 0;
        }
        .contact-section {
            text-align: center;
            margin: 30px 0;
            padding: 20px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .contact-info {
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 12px;
            display: inline-block;
            margin-top: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 25px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #9ca3af;
            font-size: 14px;
        }
        .decorative-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(40px);
            pointer-events: none;
            opacity: 0.3;
        }
        .orb-1 {
            width: 200px;
            height: 200px;
            background: #3b82f6;
            top: -100px;
            left: -100px;
        }
        .orb-2 {
            width: 150px;
            height: 150px;
            background: #8b5cf6;
            bottom: -75px;
            right: -75px;
        }
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            .container {
                padding: 20px;
            }
            .verification-code {
                font-size: 32px;
                letter-spacing: 6px;
            }
            .logo {
                font-size: 28px;
            }
            .welcome-title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="decorative-orb orb-1"></div>
    <div class="decorative-orb orb-2"></div>
    
    <div class="container">
        <div class="header">
            <div class="logo">🎓 SRIS</div>
            <div class="subtitle">Student Registration Information System</div>
        </div>

        <div class="welcome-title">
            🔐 Email Verification Required
        </div>

        <p style="font-size: 16px; margin-bottom: 25px; color: #e5e7eb;">
            Hello <strong style="color: #60a5fa;">{{ $user->name }}</strong>,
        </p>

        <p style="font-size: 15px; margin-bottom: 25px; color: #d1d5db;">
            Thank you for registering with SRIS! To complete your account setup and access the student enrollment system, 
            please verify your email address using the verification code below.
        </p>

        <div class="verification-section">
            <div class="code-label">✨ Your Verification Code</div>
            <div class="verification-code">{{ $verificationCode->code }}</div>
            <div class="expiry-notice">
                ⏰ This code expires in 15 minutes<br>
                Sent at: {{ $sentAt->format('M d, Y h:i:s A') }}
            </div>
        </div>

        <div class="instructions">
            <h3>📋 How to Verify Your Email</h3>
            <ol>
                <li>Go back to the SRIS verification page in your browser</li>
                <li>Enter the 6-digit verification code shown above</li>
                <li>Click "Verify Email" to complete the process</li>
                <li>Once verified, you can proceed with your enrollment</li>
            </ol>
        </div>

        <div class="warning">
            <p class="warning-text">
                <span class="warning-icon">⚠️</span>
                <strong>Important Security Notice:</strong><br>
                • This code is valid for 15 minutes only<br>
                • Do not share this code with anyone<br>
                • If you didn't request this verification, please ignore this email<br>
                • For security reasons, this code can only be used once
            </p>
        </div>

        <div class="contact-section">
            <p style="font-size: 15px; margin-bottom: 15px; color: #e5e7eb;">
                Need help? Contact our support team:
            </p>
            <div class="contact-info">
                <strong style="color: #60a5fa;">📧 Email:</strong> <span style="color: #d1d5db;">support@sris.edu.ph</span><br>
                <strong style="color: #60a5fa;">📞 Phone:</strong> <span style="color: #d1d5db;">(02) 8123-4567</span><br>
                <strong style="color: #60a5fa;">🕒 Office Hours:</strong> <span style="color: #d1d5db;">Mon-Fri, 8:00 AM - 5:00 PM</span>
            </div>
        </div>

        <div class="footer">
            <p>
                <strong>Student Registration Information System (SRIS)</strong><br>
                Automated Email Verification System
            </p>
            <div style="margin-top: 20px; font-size: 13px;">
                This is an automated message. Please do not reply to this email.<br>
                If you have questions, please contact our support team using the information above.
            </div>
        </div>
    </div>
</body>
</html>
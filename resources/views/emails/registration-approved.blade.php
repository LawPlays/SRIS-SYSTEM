<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Approved</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 10px;
        }
        .title {
            color: #16a34a;
            font-size: 28px;
            margin-bottom: 20px;
        }
        .content {
            margin-bottom: 30px;
        }
        .highlight {
            background-color: #f0f9ff;
            padding: 15px;
            border-left: 4px solid #2563eb;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            background-color: #2563eb;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">SRIS</div>
            <h1 class="title">🎉 Successful Registration</h1>
        </div>

        <div class="content">
            <p>Dear <strong>{{ $user->name }}</strong>,</p>

            <p>Good day!</p>

            <p>We are pleased to inform you that your registration in the Student Registration and Information System (SRIS) of Dagupan City National High School has been successfully completed.</p>

            <p>Your information has been verified and recorded in our database. You may now access your SRIS account to view or update your student profile and enrollment details.</p>

            <div style="text-align: center;">
                <a href="{{ route('login') }}" class="button">Login to Your Account</a>
            </div>

            <p>If you have any concerns or need further assistance, please don't hesitate to contact the SRIS support team or visit the school's ICT Office.</p>

            <p>Thank you for completing your registration promptly. Welcome to Dagupan City National High School!</p>

            <p>Best regards,<br>
            <strong>SRIS Administration</strong><br>
            <strong>Dagupan City National High School</strong></p>
        </div>

        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} Student Registration Information System. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
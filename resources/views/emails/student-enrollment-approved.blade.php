<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Approved - SRIS</title>
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
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            text-align: center;
            margin: 30px 0 20px 0;
        }
        .approval-section {
            text-align: center;
            margin: 40px 0;
            padding: 30px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 16px;
            color: white;
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
        }
        .approval-icon {
            font-size: 64px;
            margin-bottom: 20px;
            display: block;
        }
        .approval-message {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 15px;
        }
        .approval-details {
            font-size: 16px;
            opacity: 0.9;
            line-height: 1.8;
        }
        .enrollment-details {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 25px;
            margin: 30px 0;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .detail-label {
            font-weight: 600;
            color: #60a5fa;
        }
        .detail-value {
            color: #e5e7eb;
        }
        .next-steps {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 25px;
            margin: 30px 0;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .next-steps h3 {
            color: #60a5fa;
            margin-bottom: 15px;
            font-size: 18px;
        }
        .next-steps ol {
            margin: 0;
            padding-left: 20px;
        }
        .next-steps li {
            margin-bottom: 8px;
            color: #d1d5db;
        }
        .contact-section {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 25px;
            margin: 30px 0;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .contact-info {
            background: rgba(59, 130, 246, 0.1);
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #3b82f6;
            margin-top: 15px;
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
            background: #10b981;
            top: -100px;
            left: -100px;
        }
        .orb-2 {
            width: 150px;
            height: 150px;
            background: #34d399;
            bottom: -75px;
            right: -75px;
        }
        @media (max-width: 600px) {
            body { padding: 10px; }
            .content { padding: 25px 20px; }
            .detail-row { flex-direction: column; }
            .detail-label { margin-bottom: 5px; }
            .decorative-orb { display: none; }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="decorative-orb orb-1"></div>
        <div class="decorative-orb orb-2"></div>
        
        <div class="header">
            <div class="success-icon">✅</div>
            <h1>Enrollment Approved!</h1>
            <p>Welcome to San Rafael Integrated School</p>
        </div>

        <div class="content">
            <div class="greeting">
                Dear {{ $student->name }},
            </div>

            <div class="message">
                Congratulations! We are excited to inform you that your enrollment application for 
                <strong>{{ $enrollment->school_year }}</strong> has been <strong>approved</strong>. 
                Welcome to the SRIS family!
            </div>

            <div class="enrollment-details">
                <h3 style="color: #60a5fa; margin-bottom: 20px; font-size: 18px;">📋 Enrollment Details</h3>
                <div class="detail-row">
                    <span class="detail-label">Student Name:</span>
                    <span class="detail-value">{{ $enrollment->first_name }} {{ $enrollment->middle_name }} {{ $enrollment->last_name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">LRN:</span>
                    <span class="detail-value">{{ $enrollment->lrn }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Grade Level:</span>
                    <span class="detail-value">{{ $enrollment->grade_level }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Strand:</span>
                    <span class="detail-value">{{ $enrollment->strand }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">School Year:</span>
                    <span class="detail-value">{{ $enrollment->school_year }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value" style="color: #10b981; font-weight: 600;">✅ APPROVED</span>
                </div>
            </div>

            <div class="next-steps">
                <h3>📚 What's Next?</h3>
                <ol>
                    <li>Access your student portal using your registered credentials</li>
                    <li>Review your class schedule and academic requirements</li>
                    <li>Prepare necessary documents for the school year</li>
                    <li>Attend orientation sessions (dates will be announced)</li>
                    <li>Contact our office for any questions or concerns</li>
                </ol>
            </div>

            <div class="contact-section">
                <h3 style="color: #60a5fa; margin-bottom: 15px;">📞 Need Help?</h3>
                <p style="margin-bottom: 15px; color: #d1d5db;">
                    Our registrar's office is here to assist you with any questions about your enrollment.
                </p>
                <div class="contact-info">
                    <strong style="color: #3b82f6;">SRIS Registrar's Office</strong><br>
                    Email: registrar@sris.edu.ph<br>
                    Phone: (02) 123-4567
                </div>
            </div>

            <div class="message">
                We're thrilled to have you join our academic community and look forward to supporting 
                your educational journey at San Rafael Integrated School.
            </div>
        </div>

        <div class="footer">
            <strong>San Rafael Integrated School</strong><br>
            Student Registration Information System<br>
            <small style="opacity: 0.7;">This is an automated message. Please do not reply to this email.</small>
        </div>
    </div>
</body>
</html>
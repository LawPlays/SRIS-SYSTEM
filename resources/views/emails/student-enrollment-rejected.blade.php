<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Action Required - Missing Requirements - SRIS</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8fafc;
        }
        .email-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .header .emoji {
            font-size: 48px;
            margin-bottom: 10px;
            display: block;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #2d3748;
            margin-bottom: 20px;
        }
        .message {
            font-size: 16px;
            color: #4a5568;
            margin-bottom: 30px;
            line-height: 1.8;
        }
        .info-box {
            background: #f7fafc;
            border-left: 4px solid #4299e1;
            padding: 20px;
            margin: 25px 0;
            border-radius: 0 8px 8px 0;
        }
        .info-box h3 {
            margin: 0 0 15px 0;
            color: #2d3748;
            font-size: 18px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            padding: 5px 0;
        }
        .info-label {
            font-weight: 600;
            color: #4a5568;
        }
        .info-value {
            color: #2d3748;
        }
        .missing-requirements {
            background: #fef5e7;
            border: 1px solid #f6ad55;
            border-radius: 8px;
            padding: 25px;
            margin: 25px 0;
        }
        .missing-requirements h3 {
            color: #c53030;
            margin: 0 0 15px 0;
            display: flex;
            align-items: center;
        }
        .missing-requirements h3::before {
            content: "⚠️";
            margin-right: 10px;
        }
        .requirements-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .requirements-list li {
            background: white;
            padding: 12px 15px;
            margin-bottom: 8px;
            border-radius: 6px;
            border-left: 4px solid #f56565;
            display: flex;
            align-items: center;
        }
        .requirements-list li::before {
            content: "❌";
            margin-right: 10px;
        }
        .action-steps {
            background: #e6fffa;
            border: 1px solid #38b2ac;
            padding: 25px;
            border-radius: 8px;
            margin: 25px 0;
        }
        .action-steps h3 {
            color: #2c7a7b;
            margin: 0 0 15px 0;
            display: flex;
            align-items: center;
        }
        .action-steps h3::before {
            content: "📋";
            margin-right: 10px;
        }
        .action-steps ul {
            margin: 0;
            padding-left: 20px;
        }
        .action-steps li {
            margin-bottom: 8px;
            color: #2c7a7b;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin: 20px 0;
            text-align: center;
        }
        .footer {
            background: #2d3748;
            color: #a0aec0;
            padding: 25px 30px;
            text-align: center;
            font-size: 14px;
        }
        .footer .school-name {
            color: white;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .contact-info {
            background: #edf2f7;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
        }
        .contact-info h4 {
            margin: 0 0 10px 0;
            color: #2d3748;
        }
        @media (max-width: 600px) {
            body { padding: 10px; }
            .content { padding: 25px 20px; }
            .info-row { flex-direction: column; }
            .info-label { margin-bottom: 5px; }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <span class="emoji">📋</span>
            <h1>Action Required</h1>
            <p style="margin: 10px 0 0 0; font-size: 16px; opacity: 0.9;">Missing requirements for your enrollment</p>
        </div>

        <div class="content">
            <div class="greeting">
                Dear {{ $student->name }},
            </div>

            <div class="message">
                Thank you for submitting your enrollment application for <strong>{{ $enrollment->school_year }}</strong>. 
                @if(!empty($enrollment->rejection_reason))
                    We have reviewed your application and unfortunately, we cannot approve your enrollment at this time.
                @else
                    We have reviewed your application and found that some required documents or information are missing.
                @endif
            </div>

            <div class="info-box">
                <h3>📋 Your Application Details</h3>
                <div class="info-row">
                    <span class="info-label">Student Name:</span>
                    <span class="info-value">{{ $enrollment->first_name }} {{ $enrollment->middle_name }} {{ $enrollment->last_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email Address:</span>
                    <span class="info-value">{{ $student->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">LRN:</span>
                    <span class="info-value">{{ $enrollment->lrn }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Grade Level:</span>
                    <span class="info-value">{{ $enrollment->grade_level }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Strand:</span>
                    <span class="info-value">{{ $enrollment->strand }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">School Year:</span>
                    <span class="info-value">{{ $enrollment->school_year }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Birthdate:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($enrollment->birthdate)->format('F d, Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Place of Birth:</span>
                    <span class="info-value">{{ $enrollment->place_of_birth }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Sex:</span>
                    <span class="info-value">{{ $enrollment->sex }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Age:</span>
                    <span class="info-value">{{ $enrollment->age }} years old</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Current Address:</span>
                    <span class="info-value">{{ $enrollment->current_address }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Permanent Address:</span>
                    <span class="info-value">{{ $enrollment->permanent_address }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Father's Name:</span>
                    <span class="info-value">{{ $enrollment->father_name ?? 'Not provided' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Mother's Name:</span>
                    <span class="info-value">{{ $enrollment->mother_name ?? 'Not provided' }}</span>
                </div>
                @if($enrollment->guardian_name)
                <div class="info-row">
                    <span class="info-label">Guardian's Name:</span>
                    <span class="info-value">{{ $enrollment->guardian_name }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">Contact Number:</span>
                    <span class="info-value">{{ $enrollment->contact_number }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Application Date:</span>
                    <span class="info-value">{{ $enrollment->created_at->format('F d, Y h:i A') }}</span>
                </div>
                @if($enrollment->rejected_at)
                <div class="info-row">
                    <span class="info-label">Rejection Date:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($enrollment->rejected_at)->format('F d, Y h:i A') }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    @if(!empty($enrollment->rejection_reason))
                        <span class="info-value" style="color: #e53e3e; font-weight: 600;">❌ REJECTED</span>
                    @else
                        <span class="info-value" style="color: #e53e3e; font-weight: 600;">⏳ PENDING - Missing Requirements</span>
                    @endif
                </div>
            </div>

            {{-- Uploaded Documents Section --}}
            <div class="info-box" style="margin-top: 25px;">
                <h3>📄 Uploaded Documents</h3>
                @php
                    $grade = $enrollment->grade_level ?? null;
                    $isJHS = in_array($grade, ['Grade 7','Grade 8','Grade 9','Grade 10']);
                    $isSHS = in_array($grade, ['Grade 11','Grade 12']);
                    $levelTag = $isJHS ? 'JHS' : ($isSHS ? 'SHS' : null);
                    $docs = $student->documents ?? collect();
                    if ($levelTag) {
                        $filteredDocs = $docs->filter(function ($doc) use ($levelTag) {
                            $name = $doc->file_name ?? '';
                            return str_contains($name, ' - ' . $levelTag)
                                || (!str_contains($name, ' - JHS') && !str_contains($name, ' - SHS'));
                        });
                    } else {
                        $filteredDocs = $docs;
                    }
                @endphp
                @if($enrollment->form137 || $enrollment->psa_birth_certificate || $filteredDocs->count() > 0)
                    <div style="margin-top: 15px;">
                        {{-- Required Documents from Enrollment --}}
                        @if($enrollment->form137)
                        <div class="info-row">
                            <span class="info-label">Form 137 (Report Card{{ $levelTag ? ' - ' . $levelTag : '' }}):</span>
                            <span class="info-value" style="color: #10b981; font-weight: 600;">✅ Uploaded</span>
                        </div>
                        @endif
                        
                        @if($enrollment->psa_birth_certificate)
                        <div class="info-row">
                            <span class="info-label">PSA Birth Certificate{{ $levelTag ? ' - ' . $levelTag : '' }}:</span>
                            <span class="info-value" style="color: #10b981; font-weight: 600;">✅ Uploaded</span>
                        </div>
                        @endif
                        
                        {{-- Additional Documents --}}
                        @if($filteredDocs->count() > 0)
                            @foreach($filteredDocs as $document)
                            <div class="info-row">
                                <span class="info-label">{{ $document->file_name }}:</span>
                                <span class="info-value" style="color: #10b981; font-weight: 600;">✅ Uploaded ({{ strtoupper($document->file_type) }})</span>
                            </div>
                            @endforeach
                        @endif
                    </div>
                @else
                    <p style="color: #e53e3e; font-style: italic; margin-top: 10px;">No documents have been uploaded yet.</p>
                @endif
                
                {{-- File Attachments Notice --}}
                @if($enrollment->form137 || $enrollment->psa_birth_certificate || $filteredDocs->count() > 0)
                <div style="margin-top: 15px; padding: 15px; background-color: #f0f9ff; border-left: 4px solid #3b82f6; border-radius: 6px;">
                    <p style="margin: 0; color: #1e40af; font-weight: 600; font-size: 14px;">
                        📎 <strong>Attached Files:</strong> All your uploaded documents are attached to this email for your reference and records.
                    </p>
                </div>
                @endif
            </div>

            @if(!empty($enrollment->rejection_reason))
            <div class="missing-requirements">
                <h3>Reason for Rejection</h3>
                <p style="margin: 0; color: #744210; font-weight: 500; line-height: 1.6;">
                    {{ $enrollment->rejection_reason }}
                </p>
            </div>
            @elseif(count($missingRequirements) > 0)
            <div class="missing-requirements">
                <h3>Missing Requirements</h3>
                <p style="margin: 0 0 15px 0; color: #744210;">
                    Please provide the following missing requirements to complete your enrollment:
                </p>
                <ul class="requirements-list">
                    @foreach($missingRequirements as $requirement)
                    <li>{{ $requirement }}</li>
                    @endforeach
                </ul>
            </div>
            @else
            <div class="missing-requirements">
                <h3>Additional Information Required</h3>
                <p style="margin: 0; color: #744210;">
                    Please contact the registrar's office for specific details about the missing requirements for your enrollment.
                </p>
            </div>
            @endif

            <div class="action-steps">
                <h3>What You Need to Do</h3>
                <ul>
                    <li>Gather all the missing documents listed above</li>
                    <li>Log in to your student portal to update your information</li>
                    <li>Upload the required documents in the appropriate sections</li>
                    <li>Contact the registrar's office if you need assistance</li>
                    <li>Resubmit your application once all requirements are complete</li>
                </ul>
            </div>

            <div style="text-align: center;">
                <a href="{{ route('login', ['role' => 'student']) }}" class="cta-button">
                    Update Your Application
                </a>
            </div>

            <div class="contact-info">
                <h4>📞 Need Help?</h4>
                <p style="margin: 0; color: #4a5568;">
                    If you have questions about the requirements or need assistance with your application, 
                    please contact our registrar's office. We're here to help you complete your enrollment successfully.
                </p>
            </div>

            <div class="message">
                Don't worry! This is a common part of the enrollment process. Once you provide the missing requirements, 
                we'll review your application again promptly.
            </div>

            <div style="margin-top: 30px;">
                <p style="margin: 0; color: #4a5568;">Best regards,</p>
                <p style="margin: 5px 0 0 0; font-weight: 600; color: #2d3748;">SRIS Registrar's Office</p>
            </div>
        </div>

        <div class="footer">
            <div class="school-name">San Rafael Integrated School</div>
            <div>Student Registration Information System</div>
            <div style="margin-top: 10px; font-size: 12px;">
                This is an automated message. Please do not reply to this email.
            </div>
        </div>
    </div>
</body>
</html>

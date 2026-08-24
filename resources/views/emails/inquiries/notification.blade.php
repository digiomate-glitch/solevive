<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Travel Inquiry</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .email-wrapper {
            width: 100%;
            background-color: #f3f4f6;
            padding: 40px 0;
        }
        .email-content {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }
        .email-header {
            text-align: center;
            padding: 40px 20px 20px;
            background-color: #ffffff;
            border-bottom: 1px solid #f3f4f6;
        }
        .email-header img {
            height: 60px;
            width: auto;
        }
        .tagline {
            display: block;
            margin-top: 10px;
            font-size: 13px;
            color: #6b7280;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .email-body {
            padding: 30px 40px;
        }
        h1 {
            font-size: 22px;
            color: #111827;
            margin-top: 0;
            margin-bottom: 15px;
            font-weight: 600;
        }
        .intro {
            font-size: 15px;
            line-height: 1.6;
            color: #4b5563;
            margin-bottom: 30px;
        }
        .details-card {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 25px;
            margin-bottom: 30px;
        }
        .details-card h2 {
            font-size: 16px;
            color: #111827;
            margin-top: 0;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 10px;
        }
        .field {
            margin-bottom: 15px;
        }
        .field:last-child {
            margin-bottom: 0;
        }
        .field-label {
            font-size: 13px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
            font-weight: 500;
        }
        .field-value {
            font-size: 16px;
            color: #111827;
            font-weight: 500;
        }
        .field-value a {
            color: #0284c7;
            text-decoration: none;
        }
        .message-box {
            background-color: #f0fdf4;
            border-left: 4px solid #22c55e;
            padding: 20px;
            border-radius: 4px;
            margin-bottom: 35px;
        }
        .message-title {
            font-size: 14px;
            color: #166534;
            font-weight: 600;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .message-content {
            font-size: 15px;
            color: #15281d;
            line-height: 1.6;
            white-space: pre-line;
        }
        .action-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            background-color: #0f172a;
            color: #ffffff;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: background-color 0.2s;
        }
        .email-footer {
            background-color: #f9fafb;
            padding: 30px 40px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer-text {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 15px;
            line-height: 1.5;
        }
        .copyright {
            font-size: 12px;
            color: #9ca3af;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-content">
            <div class="email-header">
                <img src="{{ $message->embed(public_path('assets/images/logo.png')) }}" alt="Solvive Travel">
                <span class="tagline">Luxury Small-Group Travel</span>
            </div>
            
            <div class="email-body">
                <h1>New Travel Inquiry</h1>
                
                <p class="intro">
                    You have received a new travel inquiry through the Solvive Travel website. Please review the details below and follow up with the traveller at your earliest convenience.
                </p>

                <div class="details-card">
                    <h2>Traveller Details</h2>
                    
                    <div class="field">
                        <div class="field-label">Name</div>
                        <div class="field-value">{{ $inquiry->name }}</div>
                    </div>
                    
                    <div class="field">
                        <div class="field-label">Email</div>
                        <div class="field-value"><a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a></div>
                    </div>
                    
                    <div class="field">
                        <div class="field-label">Phone</div>
                        <div class="field-value">
                            @if($inquiry->phone)
                                <a href="tel:{{ $inquiry->phone }}">{{ $inquiry->phone }}</a>
                            @else
                                <span style="color: #9ca3af;">Not provided</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="field">
                        <div class="field-label">Journey of Interest</div>
                        <div class="field-value">{{ $inquiry->journey ?? 'Not specified' }}</div>
                    </div>
                </div>

                <div class="message-box">
                    <div class="message-title">Message from Traveller</div>
                    <div class="message-content">
                        @if(!empty(trim($inquiry->message)))
                            {{ $inquiry->message }}
                        @else
                            <span style="font-style: italic; color: #4b5563;">No message was provided.</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="email-footer">
                <div class="footer-text">
                    Best regards,<br>
                    <strong>Solvive Travel Team</strong>
                </div>
                <div class="copyright">
                    &copy; 2026 Solvive Travel. All rights reserved.
                </div>
            </div>
        </div>
    </div>
</body>
</html>

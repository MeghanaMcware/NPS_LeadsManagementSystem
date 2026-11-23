<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('subject', 'National Public School – Kempegowda Layout')</title>
    <style>
        body, table, td, p, a, li { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; outline: none; text-decoration: none; }
        body { margin: 0; padding: 0; width: 100% !important; background-color: #f4f6fa; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #1b2233; }
        .wrapper { width: 100%; table-layout: fixed; background-color: #f4f6fa; padding: 32px 0; }
        .main-card { background-color: #ffffff; border-radius: 12px; border: 1px solid #e1e7f0; max-width: 600px; margin: 0 auto; overflow: hidden; box-shadow: 0 4px 14px rgba(2, 27, 69, 0.06); }
        .header { background: linear-gradient(135deg, #002d62 0%, #021b45 100%); padding: 28px 32px; text-align: left; }
        .header-title { color: #ffffff; font-size: 20px; font-weight: 700; margin: 0 0 4px; letter-spacing: 0.2px; }
        .header-sub { color: #fce4ad; font-size: 13px; margin: 0; font-weight: 500; }
        .content { padding: 32px; font-size: 15px; line-height: 1.65; color: #2d3748; }
        .greeting { font-size: 17px; font-weight: 700; color: #002d62; margin-bottom: 16px; }
        .details-box { background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 18px 20px; margin: 22px 0; }
        .details-title { font-size: 14px; font-weight: 700; color: #002d62; margin: 0 0 10px; text-transform: uppercase; letter-spacing: 0.5px; }
        .detail-row { margin-bottom: 8px; font-size: 14px; }
        .detail-row:last-child { margin-bottom: 0; }
        .detail-label { font-weight: 700; color: #4a5568; display: inline-block; min-width: 170px; }
        .detail-val { color: #1a202c; }
        .btn-action { display: inline-block; background-color: #002d62; color: #ffffff !important; text-decoration: none; padding: 12px 26px; border-radius: 6px; font-weight: 700; font-size: 14px; margin: 18px 0; }
        .closing { margin-top: 26px; border-top: 1px solid #edf2f7; padding-top: 20px; font-size: 14px; color: #4a5568; }
        .closing strong { color: #002d62; }
        .footer { text-align: center; padding: 24px 20px; font-size: 12px; color: #718096; }
        .footer a { color: #002d62; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="wrapper">
        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
            <tr>
                <td align="center">
                    <table class="main-card" width="100%" cellspacing="0" cellpadding="0" border="0">
                        <!-- Brand Header -->
                        <tr>
                            <td class="header">
                                <div class="header-title">National Public School</div>
                                <div class="header-sub">Kempegowda Layout (NPS KGL) • Admissions Office</div>
                            </td>
                        </tr>

                        <!-- Body Content -->
                        <tr>
                            <td class="content">
                                @yield('content')
                            </td>
                        </tr>
                    </table>

                    <!-- Email Footer -->
                    <table class="footer" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width: 600px; margin: 0 auto;">
                        <tr>
                            <td>
                                <p style="margin: 0 0 6px;">
                                    <strong>National Public School – Kempegowda Layout</strong><br>
                                    Kempegowda Layout 7th Block, Bengaluru, Karnataka
                                </p>
                                <p style="margin: 0; color: #a0aec0;">
                                    This is an official communication regarding your admission inquiry at NPS KGL.
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>

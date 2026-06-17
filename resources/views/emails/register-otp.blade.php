<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f4f4f8;
            padding: 32px 16px;
            color: #374151;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        }
        .header {
            background: linear-gradient(135deg, #6d28d9 0%, #4c229a 100%);
            padding: 36px 32px 28px;
            text-align: center;
        }
        .header .logo-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 52px;
            height: 52px;
            background: rgba(255,255,255,0.2);
            border-radius: 14px;
            margin-bottom: 14px;
        }
        .header h1 {
            color: #fff;
            font-size: 20px;
            font-weight: 700;
            margin: 0;
        }
        .header p {
            color: rgba(255,255,255,0.75);
            font-size: 13px;
            margin-top: 4px;
        }
        .body {
            padding: 32px;
        }
        .body p {
            color: #4b5563;
            font-size: 14px;
            line-height: 1.75;
            margin-bottom: 16px;
        }
        .otp-box {
            background: #faf5ff;
            border: 2px dashed #c4b5fd;
            border-radius: 16px;
            padding: 24px 20px;
            text-align: center;
            margin: 24px 0;
        }
        .otp-label {
            font-size: 11px;
            font-weight: 600;
            color: #7c3aed;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 10px;
        }
        .otp-code {
            font-size: 42px;
            font-weight: 800;
            letter-spacing: 12px;
            color: #5b21b6;
            font-family: 'Courier New', monospace;
            line-height: 1;
        }
        .otp-expire {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 10px;
        }
        .otp-expire strong { color: #ef4444; }
        .warning-box {
            background: #fffbeb;
            border-left: 3px solid #fbbf24;
            border-radius: 0 8px 8px 0;
            padding: 12px 16px;
            margin: 20px 0;
            font-size: 13px;
            color: #92400e;
        }
        .footer {
            background: #f9fafb;
            padding: 20px 32px;
            text-align: center;
            border-top: 1px solid #f3f4f6;
        }
        .footer p {
            color: #9ca3af;
            font-size: 11px;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="26" height="26">
                    <path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0 -1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path>
                    <path d="M20 2v4"></path>
                    <path d="M22 4h-4"></path>
                    <circle cx="4" cy="20" r="2"></circle>
                </svg>
            </div>
            <h1>ngajak.my.id</h1>
            <p>Platform Undangan Digital</p>
        </div>

        <div class="body">
            <p>Halo,</p>
            <p>
                Kami menerima permintaan pendaftaran akun baru di <strong>ngajak.my.id</strong>.
                Masukkan kode berikut pada halaman pendaftaran:
            </p>

            <div class="otp-box">
                <div class="otp-label">Kode Verifikasi Anda</div>
                <div class="otp-code">{{ $otp }}</div>
                <div class="otp-expire">Berlaku selama <strong>10 menit</strong> sejak email ini dikirim</div>
            </div>

            <div class="warning-box">
                ⚠️ Jangan bagikan kode ini kepada siapapun. Tim kami tidak akan pernah meminta kode ini.
            </div>

            <p>Jika Anda tidak melakukan pendaftaran ini, abaikan email ini. Akun Anda tetap aman.</p>
            <p>Salam hangat,<br><strong>Tim ngajak.my.id</strong></p>
        </div>

        <div class="footer">
            <p>
                © {{ date('Y') }} ngajak.my.id. All rights reserved.<br>
                Email ini dikirim secara otomatis, mohon jangan membalas email ini.
            </p>
        </div>
    </div>
</body>
</html>
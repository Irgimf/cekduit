<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: sans-serif; background: #f3f4f6; padding: 24px;">
    <div style="max-width: 480px; margin: 0 auto; background: #fff; border-radius: 8px; padding: 32px;">
        <h2 style="color: #4f46e5; margin-top: 0;">CekDuit</h2>
        <p>Gunakan kode berikut untuk {{ $purpose }}:</p>
        <div style="font-size: 32px; font-weight: bold; letter-spacing: 8px; text-align: center; background: #eef2ff; color: #4338ca; padding: 16px; border-radius: 8px; margin: 24px 0;">
            {{ $otpCode }}
        </div>
        <p style="color: #6b7280; font-size: 14px;">Kode ini berlaku selama <strong>5 menit</strong>. Jangan bagikan kode ini ke siapapun.</p>
        <p style="color: #6b7280; font-size: 14px;">Kalau kamu tidak meminta kode ini, abaikan saja email ini.</p>
    </div>
</body>
</html>
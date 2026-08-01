<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hubungi Kami — CekDuit</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet"/>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Figtree', sans-serif; background: #F0F4F8; color: #1E293B; }
        .container { max-width: 600px; margin: 0 auto; padding: 40px 24px; }
        .card { background: #fff; border-radius: 16px; padding: 40px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .back { display: inline-flex; align-items: center; gap: 6px; color: #014BAA; font-size: 14px; font-weight: 600; text-decoration: none; margin-bottom: 24px; }
        .logo { display: flex; align-items: center; gap: 10px; margin-bottom: 28px; }
        .logo-icon { width: 40px; height: 40px; background: #014BAA; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
        .logo-text { font-size: 20px; font-weight: 800; color: #014BAA; }
        h1 { font-size: 24px; font-weight: 800; color: #0F172A; margin-bottom: 8px; }
        p { font-size: 14px; color: #64748B; line-height: 1.7; margin-bottom: 24px; }
        .contact-item {
            display: flex; align-items: center; gap: 14px;
            padding: 16px; background: #F8FAFF; border-radius: 12px;
            margin-bottom: 12px; text-decoration: none; color: inherit;
            border: 1px solid #E2E8F0; transition: all 0.15s;
        }
        .contact-item:hover { border-color: #014BAA; background: #E8F0FB; }
        .contact-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .contact-label { font-size: 12px; color: #94A3B8; font-weight: 500; margin-bottom: 2px; }
        .contact-value { font-size: 15px; font-weight: 700; color: #1E293B; }
    </style>
</head>
<body>
<div class="container">
    <a href="{{ url()->previous() }}" class="back">← Kembali</a>
    <div class="card">
        <div class="logo">
            <div class="logo-icon">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:22px;height:22px;" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2.5">
                    <text x="4" y="18" font-family="Arial" font-size="14" font-weight="bold" fill="white">Rp</text>
                </svg>
            </div>
            <span class="logo-text">CekDuit</span>
        </div>

        <h1>Hubungi Kami</h1>
        <p>Ada pertanyaan, masalah, atau saran? Kami siap membantu! Pilih salah satu cara berikut untuk menghubungi tim CekDuit.</p>

        <a href="https://wa.me/6282317179877" target="_blank" class="contact-item">
            <div class="contact-icon" style="background:#DCFCE7;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:22px;height:22px;color:#16a34a;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
            </div>
            <div>
                <div class="contact-label">WhatsApp (Respon Cepat)</div>
                <div class="contact-value">+62 823-1717-9877</div>
            </div>
        </a>

        <a href="mailto:cekduit24@gmail.com" class="contact-item">
            <div class="contact-icon" style="background:#E8F0FB;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:22px;height:22px;color:#014BAA;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <div class="contact-label">Email</div>
                <div class="contact-value">cekduit24@gmail.com</div>
            </div>
        </a>

        <div style="margin-top:24px;padding:16px;background:#FEF9C3;border-radius:12px;font-size:13px;color:#92400E;">
            ⏰ <strong>Jam operasional:</strong> Senin – Jumat, 08.00 – 17.00 WIB.<br>
            Balasan via WhatsApp biasanya dalam 1–2 jam pada jam kerja.
        </div>
    </div>
</div>
</body>
</html>
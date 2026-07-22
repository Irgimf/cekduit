<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mengarahkan ke WhatsApp — CekDuit</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Figtree', sans-serif;
            background: #F0F4F8;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .card {
            background: #fff;
            border-radius: 20px;
            padding: 40px 32px;
            text-align: center;
            max-width: 420px;
            width: 100%;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        }
        .icon {
            width: 72px;
            height: 72px;
            background: #DCFCE7;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        h2 { font-size: 20px; font-weight: 700; color: #0F172A; margin-bottom: 10px; }
        p { font-size: 14px; color: #64748B; line-height: 1.6; margin-bottom: 24px; }
        .progress {
            height: 4px;
            background: #E2E8F0;
            border-radius: 99px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .progress-bar {
            height: 100%;
            background: #25D366;
            border-radius: 99px;
            animation: fillBar 2s ease forwards;
        }
        @keyframes fillBar {
            from { width: 0%; }
            to   { width: 100%; }
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 13px 24px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            width: 100%;
            margin-bottom: 10px;
        }
        .btn-wa   { background: #25D366; color: #fff; }
        .btn-back { background: #F1F5F9; color: #64748B; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:36px;height:36px;color:#16a34a;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
        </div>

        <h2>Mengarahkan ke WhatsApp...</h2>
        <p>Pesan otomatis sudah disiapkan. WhatsApp akan terbuka dalam 2 detik.</p>

        <div class="progress">
            <div class="progress-bar"></div>
        </div>

        <a href="{{ $waUrl }}" target="_blank" class="btn btn-wa" id="wa-btn">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                <path d="M12 0C5.373 0 0 5.373 0 12c0 2.124.554 4.118 1.527 5.847L0 24l6.338-1.503A11.959 11.959 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.006-1.368l-.36-.214-3.727.883.937-3.633-.235-.373A9.818 9.818 0 1112 21.818z"/>
            </svg>
            Buka WhatsApp Sekarang
        </a>

        <a href="{{ route('payment.pending') }}" class="btn btn-back">
            Lanjut ke halaman konfirmasi →
        </a>
    </div>

    <script>
        // Auto buka WA setelah 2 detik
        setTimeout(() => {
            window.open('{{ $waUrl }}', '_blank');
            // Redirect ke halaman pending setelah WA terbuka
            setTimeout(() => {
                window.location.href = '{{ route('payment.pending') }}';
            }, 1500);
        }, 2000);
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CekDuit — Kelola Keuangan Pribadi dengan Mudah</title>
    <meta name="description" content="Aplikasi manajemen keuangan pribadi untuk pelajar Indonesia. Catat pemasukan, pengeluaran, dan kelola rekening dalam satu tempat.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet"/>
    <link rel="icon" type="image/svg+xml" href="/icons/icon.svg">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --blue:      #014BAA;
            --blue-dark: #013a85;
            --blue-mid:  #0166E8;
            --blue-light:#E8F0FB;
            --cream:     #F8F3F0;
            --dark:      #0F172A;
            --muted:     #64748B;
            --border:    #E2E8F0;
            --green:     #22C55E;
            --radius:    12px;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Figtree', -apple-system, sans-serif;
            color: var(--dark);
            background: #fff;
            line-height: 1.6;
        }

        a { text-decoration: none; color: inherit; }
        img { max-width: 100%; }

        /* ===== NAVBAR ===== */
        .nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            padding: 0 24px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 20px;
            font-weight: 800;
            color: var(--blue);
        }

        .nav-logo-icon {
            width: 36px;
            height: 36px;
            background: var(--blue);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-link {
            font-size: 14px;
            font-weight: 500;
            color: var(--muted);
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.15s;
        }

        .nav-link:hover { color: var(--blue); background: var(--blue-light); }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: var(--radius);
            font-size: 14px;
            font-weight: 600;
            transition: all 0.15s;
            cursor: pointer;
            border: none;
            font-family: inherit;
        }

        .btn:hover { transform: translateY(-1px); }
        .btn:active { transform: translateY(0); }

        .btn-primary {
            background: var(--blue);
            color: #fff;
            box-shadow: 0 4px 14px rgba(1,75,170,0.3);
        }

        .btn-primary:hover { background: var(--blue-dark); box-shadow: 0 6px 20px rgba(1,75,170,0.4); }

        .btn-outline {
            background: transparent;
            color: var(--blue);
            border: 1.5px solid var(--blue);
        }

        .btn-outline:hover { background: var(--blue-light); }

        .btn-white {
            background: #fff;
            color: var(--blue);
            box-shadow: 0 4px 14px rgba(0,0,0,0.1);
        }

        .btn-lg {
            padding: 14px 28px;
            font-size: 16px;
            border-radius: 14px;
        }

        /* ===== HERO ===== */
        .hero {
            min-height: 100vh;
            background: linear-gradient(160deg, #014BAA 0%, #0166E8 50%, #0284C7 100%);
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 100px 24px 60px;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -100px; right: -100px;
            width: 500px; height: 500px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -150px; left: -80px;
            width: 600px; height: 400px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }

        .hero-container {
            max-width: 1100px;
            margin: 0 auto;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,0.15);
            color: #fff;
            padding: 6px 14px;
            border-radius: 99px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 20px;
            backdrop-filter: blur(8px);
        }

        .hero-title {
            font-size: clamp(32px, 5vw, 56px);
            font-weight: 900;
            color: #fff;
            line-height: 1.1;
            margin-bottom: 20px;
        }

        .hero-title span {
            color: #93C5FD;
        }

        .hero-desc {
            font-size: 17px;
            color: rgba(255,255,255,0.8);
            margin-bottom: 36px;
            line-height: 1.7;
        }

        .hero-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .hero-stats {
            display: flex;
            gap: 32px;
            margin-top: 48px;
            padding-top: 32px;
            border-top: 1px solid rgba(255,255,255,0.15);
        }

        .hero-stat-num {
            font-size: 28px;
            font-weight: 800;
            color: #fff;
        }

        .hero-stat-label {
            font-size: 13px;
            color: rgba(255,255,255,0.7);
            margin-top: 2px;
        }

        /* Phone mockup */
        .hero-phone {
            display: flex;
            justify-content: center;
        }

        .phone-frame {
            width: 260px;
            background: #0F172A;
            border-radius: 40px;
            padding: 12px;
            box-shadow:
                0 40px 80px rgba(0,0,0,0.4),
                0 0 0 1px rgba(255,255,255,0.1),
                inset 0 0 0 1px rgba(255,255,255,0.05);
            transform: rotate(-2deg);
            transition: transform 0.3s ease;
        }

        .phone-frame:hover { transform: rotate(0deg) scale(1.02); }

        .phone-screen {
            background: #F0F4F8;
            border-radius: 30px;
            overflow: hidden;
            min-height: 480px;
        }

        .phone-status {
            background: #014BAA;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
        }

        .phone-status-time { font-size: 11px; color: #fff; font-weight: 700; }
        .phone-status-icons { display: flex; gap: 4px; align-items: center; }

        .phone-header {
            background: linear-gradient(135deg, #014BAA, #0166E8);
            padding: 16px;
        }

        .phone-greeting { font-size: 10px; color: rgba(255,255,255,0.75); margin-bottom: 2px; }
        .phone-name { font-size: 13px; font-weight: 700; color: #fff; margin-bottom: 12px; }
        .phone-balance-label { font-size: 9px; color: rgba(255,255,255,0.7); margin-bottom: 3px; }
        .phone-balance { font-size: 20px; font-weight: 800; color: #fff; }

        .phone-shortcuts {
            background: #fff;
            border-radius: 16px 16px 0 0;
            margin-top: -10px;
            padding: 14px 14px 10px;
        }

        .phone-shortcut-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 6px;
        }

        .phone-shortcut {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }

        .phone-shortcut-icon {
            width: 36px;
            height: 36px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .phone-shortcut-label {
            font-size: 7px;
            font-weight: 600;
            color: #1E293B;
            text-align: center;
            line-height: 1.2;
        }

        .phone-content {
            padding: 10px 14px;
        }

        .phone-section-title {
            font-size: 11px;
            font-weight: 700;
            color: #1E293B;
            margin-bottom: 8px;
        }

        .phone-tx-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px;
            background: #fff;
            border-radius: 10px;
            margin-bottom: 6px;
        }

        .phone-tx-icon {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .phone-tx-name { font-size: 10px; font-weight: 600; color: #1E293B; }
        .phone-tx-sub  { font-size: 8px; color: #94A3B8; }
        .phone-tx-amount { font-size: 10px; font-weight: 700; margin-left: auto; }

        /* ===== SECTION BASE ===== */
        .section { padding: 80px 24px; }
        .section-alt { background: var(--cream); }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            width: 100%;
        }

        .section-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--blue);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 10px;
        }

        .section-title {
            font-size: clamp(24px, 4vw, 40px);
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 14px;
            line-height: 1.2;
        }

        .section-desc {
            font-size: 16px;
            color: var(--muted);
            max-width: 560px;
            line-height: 1.7;
        }

        .section-header { margin-bottom: 56px; }

        /* ===== FEATURES ===== */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
        }

        .feature-card {
            background: #fff;
            border-radius: 16px;
            padding: 28px;
            border: 1px solid var(--border);
            transition: all 0.2s;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--blue), var(--blue-mid));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s;
        }

        .feature-card:hover {
            border-color: var(--blue);
            box-shadow: 0 8px 32px rgba(1,75,170,0.12);
            transform: translateY(-4px);
        }

        .feature-card:hover::before { transform: scaleX(1); }

        .feature-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: var(--blue-light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .feature-title {
            font-size: 17px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .feature-desc {
            font-size: 14px;
            color: var(--muted);
            line-height: 1.6;
        }

        .feature-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #FEF9C3;
            color: #92400E;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 99px;
            margin-top: 10px;
        }

        /* ===== PRICING ===== */
        .pricing-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            max-width: 800px;
            margin: 0 auto;
        }

        .pricing-card {
            background: #fff;
            border-radius: 20px;
            padding: 32px;
            border: 2px solid var(--border);
            transition: all 0.2s;
            position: relative;
        }

        .pricing-card.featured {
            border-color: var(--blue);
            background: linear-gradient(160deg, #014BAA 0%, #0166E8 100%);
            color: #fff;
        }

        .pricing-badge {
            position: absolute;
            top: -14px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--green);
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 16px;
            border-radius: 99px;
            white-space: nowrap;
        }

        .pricing-name {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 8px;
            color: var(--muted);
        }

        .pricing-card.featured .pricing-name {
            color: rgba(255,255,255,0.75);
        }

        .pricing-price {
            font-size: 40px;
            font-weight: 900;
            color: var(--dark);
            line-height: 1;
            margin-bottom: 4px;
        }

        .pricing-card.featured .pricing-price { color: #fff; }

        .pricing-period {
            font-size: 14px;
            color: var(--muted);
            margin-bottom: 24px;
        }

        .pricing-card.featured .pricing-period { color: rgba(255,255,255,0.7); }

        .pricing-annual {
            font-size: 13px;
            font-weight: 500;
            color: var(--green);
            background: #DCFCE7;
            padding: 6px 12px;
            border-radius: 8px;
            margin-bottom: 24px;
            display: inline-block;
        }

        .pricing-card.featured .pricing-annual {
            background: rgba(255,255,255,0.15);
            color: #fff;
        }

        .pricing-features {
            list-style: none;
            margin-bottom: 28px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .pricing-feature {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: var(--muted);
        }

        .pricing-card.featured .pricing-feature { color: rgba(255,255,255,0.9); }

        .pricing-feature-check {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: var(--blue-light);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .pricing-card.featured .pricing-feature-check {
            background: rgba(255,255,255,0.2);
        }

        .pricing-feature-check svg {
            width: 10px;
            height: 10px;
            stroke: var(--blue);
        }

        .pricing-card.featured .pricing-feature-check svg { stroke: #fff; }

        .pricing-feature.disabled { opacity: 0.4; }

        .pricing-feature.disabled .pricing-feature-check {
            background: #F1F5F9;
        }

        /* ===== HOW IT WORKS ===== */
        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 32px;
            position: relative;
        }

        .step {
            text-align: center;
        }

        .step-number {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--blue), var(--blue-mid));
            color: #fff;
            font-size: 20px;
            font-weight: 800;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            box-shadow: 0 8px 24px rgba(1,75,170,0.3);
        }

        .step-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .step-desc {
            font-size: 14px;
            color: var(--muted);
            line-height: 1.6;
        }

        /* ===== CTA ===== */
        .cta-section {
            background: linear-gradient(135deg, #014BAA 0%, #0166E8 100%);
            padding: 80px 24px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
        }

        .cta-title {
            font-size: clamp(28px, 4vw, 44px);
            font-weight: 900;
            color: #fff;
            margin-bottom: 16px;
        }

        .cta-desc {
            font-size: 17px;
            color: rgba(255,255,255,0.8);
            margin-bottom: 36px;
            max-width: 480px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* ===== FOOTER ===== */
        .footer {
            background: var(--dark);
            padding: 48px 24px 24px;
            color: rgba(255,255,255,0.7);
        }

        .footer-container {
            max-width: 1100px;
            margin: 0 auto;
        }

        .footer-top {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-brand-name {
            font-size: 20px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer-brand-desc {
            font-size: 14px;
            line-height: 1.6;
            max-width: 280px;
        }

        .footer-col-title {
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 16px;
        }

        .footer-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .footer-links a {
            font-size: 14px;
            color: rgba(255,255,255,0.6);
            transition: color 0.15s;
        }

        .footer-links a:hover { color: #fff; }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .footer-copy {
            font-size: 13px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .hero-container {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero-phone { order: -1; }
            .phone-frame { width: 200px; transform: none; }
            .phone-frame:hover { transform: none; }

            .hero-actions { justify-content: center; }
            .hero-stats { justify-content: center; }

            .pricing-grid {
                grid-template-columns: 1fr;
                max-width: 400px;
            }

            .footer-top {
                grid-template-columns: 1fr;
                gap: 32px;
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }

            .nav-links { display: none; }
        }

        @media (max-width: 480px) {
            .hero { padding: 80px 20px 48px; }
            .section { padding: 56px 20px; }
        }

        /* ===== SMOOTH ANIMATIONS ===== */
        @keyframes float {
            0%, 100% { transform: rotate(-2deg) translateY(0); }
            50%       { transform: rotate(-2deg) translateY(-12px); }
        }

        .phone-frame { animation: float 4s ease-in-out infinite; }

        @media (max-width: 768px) {
            .phone-frame { animation: none; }
        }
    </style>
</head>
<body>

{{-- ===== NAVBAR ===== --}}
<nav class="nav">
    <a href="/" class="nav-logo">
        <div class="nav-logo-icon">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        CekDuit
    </a>

    <div class="nav-links">
        <a href="#fitur" class="nav-link">Fitur</a>
        <a href="#cara-kerja" class="nav-link">Cara Kerja</a>
        <a href="#harga" class="nav-link">Harga</a>
        <a href="{{ route('login') }}" class="nav-link">Masuk</a>
        <a href="{{ route('register') }}" class="btn btn-primary" style="padding:9px 18px;">
            Daftar Gratis
        </a>
    </div>
</nav>

{{-- ===== HERO ===== --}}
<section class="hero">
    <div class="hero-container">
        <div class="hero-content">
            <div class="hero-badge">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l14 9-14 9V3z"/>
                </svg>
                Tersedia di Web & Mobile
            </div>

            <h1 class="hero-title">
                Kelola Keuangan<br>
                <span>Lebih Cerdas</span><br>
                & Terorganisir
            </h1>

            <p class="hero-desc">
                CekDuit membantu kalangan pelajar dan masyarakat umum mencatat pemasukan, pengeluaran, dan mengelola rekening dalam satu aplikasi yang mudah digunakan.
            </p>

            <div class="hero-actions">
                <a href="{{ route('register') }}" class="btn btn-white btn-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Mulai Gratis
                </a>
                <a href="#fitur" class="btn btn-outline" style="border-color:rgba(255,255,255,0.4);color:#fff;" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='transparent'">
                    Lihat Fitur
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </a>
            </div>

            <div class="hero-stats">
                <div>
                    <div class="hero-stat-num">100%</div>
                    <div class="hero-stat-label">Gratis daftar</div>
                </div>
                <div>
                    <div class="hero-stat-num">PWA</div>
                    <div class="hero-stat-label">Bisa install di HP</div>
                </div>
                <div>
                    <div class="hero-stat-num">OTP</div>
                    <div class="hero-stat-label">Keamanan email</div>
                </div>
            </div>
        </div>

        {{-- Phone Mockup --}}
        <div class="hero-phone">
            <div class="phone-frame">
                <div class="phone-screen">
                    <div class="phone-status">
                        <span class="phone-status-time">09.41</span>
                        <div class="phone-status-icons">
                            <svg style="width:10px;height:10px;" fill="white" viewBox="0 0 24 24"><path d="M1.5 8.5a13 13 0 0121 0M5 12a10 10 0 0114 0M8.5 15.5a6 6 0 017 0M12 19h.01"/></svg>
                            <svg style="width:10px;height:10px;" fill="white" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="11" rx="2"/><path d="M22 11V9"/></svg>
                        </div>
                    </div>
                    <div class="phone-header">
                        <div class="phone-greeting">Selamat Pagi, 👋</div>
                        <div class="phone-name">Akun Pengguna</div>
                        <div class="phone-balance-label">Total Saldo</div>
                        <div class="phone-balance">Rp 2.450.000</div>
                    </div>
                    <div class="phone-shortcuts">
                        <div class="phone-shortcut-grid">
                            <div class="phone-shortcut">
                                <div class="phone-shortcut-icon" style="background:#DCFCE7;">
                                    <svg style="width:16px;height:16px;color:#16a34a;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                </div>
                                <span class="phone-shortcut-label">Catat Pemasukan</span>
                            </div>
                            <div class="phone-shortcut">
                                <div class="phone-shortcut-icon" style="background:#FEE2E2;">
                                    <svg style="width:16px;height:16px;color:#dc2626;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                </div>
                                <span class="phone-shortcut-label">Catat Pengeluaran</span>
                            </div>
                            <div class="phone-shortcut">
                                <div class="phone-shortcut-icon" style="background:#E0E7FF;">
                                    <svg style="width:16px;height:16px;color:#4338ca;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                </div>
                                <span class="phone-shortcut-label">Transfer</span>
                            </div>
                            <div class="phone-shortcut">
                                <div class="phone-shortcut-icon" style="background:#FEF9C3;">
                                    <svg style="width:16px;height:16px;color:#ca8a04;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                </div>
                                <span class="phone-shortcut-label">Rekening</span>
                            </div>
                        </div>
                    </div>
                    <div class="phone-content">
                        <div class="phone-section-title">Transaksi Terbaru</div>
                        <div class="phone-tx-item">
                            <div class="phone-tx-icon" style="background:#DCFCE7;">
                                <svg style="width:12px;height:12px;color:#16a34a;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            </div>
                            <div>
                                <div class="phone-tx-name">Gaji Bulanan</div>
                                <div class="phone-tx-sub">BCA · 1 Jul</div>
                            </div>
                            <div class="phone-tx-amount" style="color:#16a34a;">+Rp 2jt</div>
                        </div>
                        <div class="phone-tx-item">
                            <div class="phone-tx-icon" style="background:#FEE2E2;">
                                <svg style="width:12px;height:12px;color:#dc2626;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/></svg>
                            </div>
                            <div>
                                <div class="phone-tx-name">Makan Siang</div>
                                <div class="phone-tx-sub">GoPay · 2 Jul</div>
                            </div>
                            <div class="phone-tx-amount" style="color:#dc2626;">-Rp 25rb</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== FITUR ===== --}}
<section class="section" id="fitur">
    <div class="container">
        <div class="section-header">
            <div class="section-label">Fitur Unggulan</div>
            <h2 class="section-title">Semua yang kamu butuhkan<br>untuk mengatur keuangan</h2>
            <p class="section-desc">Dirancang khusus untuk semua kalangan pelajar yang ingin mulai mengelola keuangan dengan serius.</p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:24px;height:24px;color:#014BAA;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <div class="feature-title">Multi Rekening</div>
                <div class="feature-desc">Kelola semua rekening dalam satu tempat — dompet, bank (BCA, BSI, Seabank, dll), dan e-wallet (GoPay, Dana, OVO).</div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:24px;height:24px;color:#014BAA;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                    </svg>
                </div>
                <div class="feature-title">Catat Transaksi</div>
                <div class="feature-desc">Input pemasukan dan pengeluaran dengan cepat. Kategorikan sesuai kebutuhan dan lihat riwayat kapan saja.</div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:24px;height:24px;color:#014BAA;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                </div>
                <div class="feature-title">Transfer Antar Rekening</div>
                <div class="feature-desc">Pindahkan saldo antar rekening dengan mudah. Saldo otomatis terupdate dan tidak mempengaruhi laporan pemasukan/pengeluaran.</div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:24px;height:24px;color:#014BAA;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div class="feature-title">Laporan & Analitik</div>
                <div class="feature-desc">Lihat tren keuangan 6 bulan terakhir, breakdown per kategori, dan export laporan ke PDF atau Excel.</div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:24px;height:24px;color:#014BAA;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="feature-title">PWA — Install di HP</div>
                <div class="feature-desc">Bisa diinstall di iPhone dan Android layaknya aplikasi native. Tampilan mobile yang bersih dan nyaman digunakan setiap hari.</div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:24px;height:24px;color:#014BAA;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div class="feature-title">Keamanan OTP</div>
                <div class="feature-desc">Verifikasi email via OTP saat daftar dan reset password. Data keuangan kamu terlindungi dengan aman.</div>
            </div>
        </div>
    </div>
</section>

{{-- ===== CARA KERJA ===== --}}
<section class="section section-alt" id="cara-kerja">
    <div class="container">
        <div class="section-header" style="text-align:center;">
            <div class="section-label" style="text-align:center;">Cara Kerja</div>
            <h2 class="section-title" style="margin:0 auto 14px;">Mulai dalam 3 langkah mudah</h2>
            <p class="section-desc" style="margin:0 auto;">Tidak perlu tutorial panjang. CekDuit dirancang agar langsung bisa digunakan.</p>
        </div>

        <div class="steps-grid">
            <div class="step">
                <div class="step-number">1</div>
                <div class="step-title">Daftar Gratis</div>
                <div class="step-desc">Buat akun dengan email kamu. Verifikasi via OTP yang dikirim ke email, selesai dalam 1 menit.</div>
            </div>
            <div class="step">
                <div class="step-number">2</div>
                <div class="step-title">Tambah Rekening</div>
                <div class="step-desc">Masukkan semua rekeningmu — dompet, tabungan bank, atau e-wallet. Saldo awal otomatis Rp 0.</div>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <div class="step-title">Mulai Mencatat</div>
                <div class="step-desc">Catat setiap transaksi. Dashboard langsung menampilkan ringkasan keuangan kamu secara realtime.</div>
            </div>
        </div>
    </div>
</section>

{{-- ===== HARGA ===== --}}
<section class="section" id="harga">
    <div class="container">
        <div class="section-header" style="text-align:center;">
            <div class="section-label" style="text-align:center;">Harga</div>
            <h2 class="section-title" style="margin:0 auto 14px;">Terjangkau untuk semua kalangan</h2>
            <p class="section-desc" style="margin:0 auto;">Mulai gratis, upgrade kapan saja saat kamu butuh fitur lebih.</p>
        </div>

        <div class="pricing-grid">
            {{-- Free --}}
            <div class="pricing-card">
                <div class="pricing-name">Gratis</div>
                <div class="pricing-price">Rp 0</div>
                <div class="pricing-period">selamanya</div>

                <ul class="pricing-features">
                    <li class="pricing-feature">
                        <div class="pricing-feature-check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
                        Maksimal 2 rekening
                    </li>
                    <li class="pricing-feature">
                        <div class="pricing-feature-check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
                        Maksimal 5 kategori
                    </li>
                    <li class="pricing-feature">
                        <div class="pricing-feature-check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
                        Riwayat transaksi 30 hari
                    </li>
                    <li class="pricing-feature">
                        <div class="pricing-feature-check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
                        Dashboard & grafik dasar
                    </li>
                    <li class="pricing-feature">
                        <div class="pricing-feature-check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
                        PWA (install di HP)
                    </li>
                    <li class="pricing-feature disabled">
                        <div class="pricing-feature-check"><svg fill="none" viewBox="0 0 24 24" stroke="#94A3B8"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></div>
                        Export PDF & Excel
                    </li>
                    <li class="pricing-feature disabled">
                        <div class="pricing-feature-check"><svg fill="none" viewBox="0 0 24 24" stroke="#94A3B8"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></div>
                        Laporan lanjutan
                    </li>
                </ul>

                <a href="{{ route('register') }}" class="btn btn-outline" style="width:100%;justify-content:center;padding:13px;">
                    Mulai Gratis
                </a>
            </div>

            {{-- Premium --}}
            <div class="pricing-card featured">
                <div class="pricing-badge">⭐ Paling Populer</div>
                <div class="pricing-name">Premium</div>
                <div class="pricing-price">Rp 15rb</div>
                <div class="pricing-period">/bulan</div>
                <div class="pricing-annual">💡 Hemat 33% — Rp 120.000/tahun</div>

                <ul class="pricing-features">
                    <li class="pricing-feature">
                        <div class="pricing-feature-check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
                        Rekening tidak terbatas
                    </li>
                    <li class="pricing-feature">
                        <div class="pricing-feature-check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
                        Kategori tidak terbatas
                    </li>
                    <li class="pricing-feature">
                        <div class="pricing-feature-check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
                        Riwayat transaksi selamanya
                    </li>
                    <li class="pricing-feature">
                        <div class="pricing-feature-check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
                        Export PDF & Excel
                    </li>
                    <li class="pricing-feature">
                        <div class="pricing-feature-check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
                        Laporan & analitik lanjutan
                    </li>
                    <li class="pricing-feature">
                        <div class="pricing-feature-check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
                        Budget & target tabungan
                    </li>
                    <li class="pricing-feature">
                        <div class="pricing-feature-check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
                        Semua fitur gratis +
                    </li>
                </ul>

                <a href="{{ route('register') }}" class="btn btn-white" style="width:100%;justify-content:center;padding:13px;color:#014BAA;font-weight:700;">
                    Coba Gratis Dulu →
                </a>
            </div>
        </div>

        <p style="text-align:center;margin-top:28px;font-size:14px;color:#94A3B8;">
            Daftar gratis tanpa kartu kredit. Upgrade kapan saja via QRIS, transfer bank, atau e-wallet.
        </p>
    </div>
</section>

{{-- ===== CTA ===== --}}
<section class="cta-section">
    <div style="position:relative;z-index:1;">
        <h2 class="cta-title">Mulai kelola keuanganmu hari ini</h2>
        <p class="cta-desc">Bergabung dan rasakan bedanya punya catatan keuangan yang rapi dan terorganisir.</p>
        <div class="cta-actions">
            <a href="{{ route('register') }}" class="btn btn-white btn-lg">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                Daftar Gratis Sekarang
            </a>
            <a href="{{ route('login') }}" class="btn" style="border:2px solid rgba(255,255,255,0.4);color:#fff;background:transparent;padding:14px 28px;font-size:16px;border-radius:14px;" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='transparent'">
                Sudah punya akun? Masuk
            </a>
        </div>
    </div>
</section>

{{-- ===== FOOTER ===== --}}
<footer class="footer">
    <div class="footer-container">
        <div class="footer-top">
            <div>
                <div class="footer-brand-name">
                    <div style="width:32px;height:32px;background:#014BAA;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    CekDuit
                </div>
                <p class="footer-brand-desc">
                    Aplikasi manajemen keuangan pribadi yang dirancang untuk pelajar Indonesia. Catat, kelola, dan analisis keuanganmu dengan mudah.
                </p>
            </div>

            <div>
                <div class="footer-col-title">Aplikasi</div>
                <ul class="footer-links">
                    <li><a href="#fitur">Fitur</a></li>
                    <li><a href="#cara-kerja">Cara Kerja</a></li>
                    <li><a href="#harga">Harga</a></li>
                    <li><a href="{{ route('register') }}">Daftar Gratis</a></li>
                    <li><a href="{{ route('login') }}">Masuk</a></li>
                </ul>
            </div>

            <div>
                <div class="footer-col-title">Info</div>
                <ul class="footer-links">
                    <li><a href="#">Syarat & Ketentuan</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                    <li><a href="#">Hubungi Kami</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-copy">
                &copy; {{ date('Y') }} CekDuit. Dibuat dengan ❤️ untuk masyarakat Indonesia.
            </div>
            <div style="font-size:13px;">
                Aman · Terpercaya · Mudah Digunakan
            </div>
        </div>
    </div>
</footer>

</body>
</html>
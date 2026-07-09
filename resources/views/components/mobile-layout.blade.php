@props(['title' => config('app.name')])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#014BAA">

    {{-- PWA Meta --}}
    <meta name="application-name" content="CekDuit">
    <meta name="mobile-web-app-capable" content="yes">

    {{-- iOS Specific --}}
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="CekDuit">
    <link rel="apple-touch-icon" href="/icons/icon-192.png">
    <link rel="apple-touch-icon" sizes="192x192" href="/icons/icon-192.png">
    <link rel="apple-touch-icon" sizes="512x512" href="/icons/icon-512.png">

    {{-- Splash screen iOS --}}
    <link rel="apple-touch-startup-image" href="/icons/icon-512.png">

    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/svg+xml" href="/icons/icon.svg">

    <title>CekDuit</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet"/>
    <style>
    * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; margin: 0; padding: 0; }
    body { font-family: 'Figtree', -apple-system, sans-serif; background: #F0F4F8; }
    .mobile-app { max-width: 480px; margin: 0 auto; min-height: 100vh; }
    .mobile-main { padding-bottom: 80px; }
    .mobile-header { background: linear-gradient(135deg, #014BAA 0%, #0166E8 100%); padding: 20px 20px 32px; }
    .mobile-header-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
    .mobile-header-greeting { color: rgba(255,255,255,0.8); font-size: 13px; font-weight: 500; margin-bottom: 2px; }
    .mobile-header-name { color: #fff; font-size: 17px; font-weight: 700; }
    .mobile-header-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.3); }
    .mobile-balance-label { color: rgba(255,255,255,0.75); font-size: 12px; font-weight: 500; margin-bottom: 6px; display: flex; align-items: center; gap: 6px; }
    .mobile-balance-toggle { background: none; border: none; padding: 0; cursor: pointer; color: rgba(255,255,255,0.75); }
    .mobile-balance-amount { color: #fff; font-size: 28px; font-weight: 800; }
    .mobile-shortcuts { background: #fff; border-radius: 20px 20px 0 0; margin-top: -16px; padding: 20px 16px 12px; }
    .mobile-shortcut-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; }
    .mobile-shortcut-item { display: flex; flex-direction: column; align-items: center; gap: 6px; text-decoration: none; cursor: pointer; background: none; border: none; padding: 4px; font-family: inherit; }
    .mobile-shortcut-icon { width: 52px; height: 52px; border-radius: 16px; display: flex; align-items: center; justify-content: center; }
    .mobile-shortcut-label { font-size: 11px; font-weight: 600; color: #1E293B; text-align: center; }
    .mobile-section { padding: 0 16px; margin-top: 16px; }
    .mobile-section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
    .mobile-section-title { font-size: 15px; font-weight: 700; color: #1E293B; }
    .mobile-section-link { font-size: 12px; font-weight: 600; color: #014BAA; text-decoration: none; }
    .mobile-stat-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 10px; }
    .mobile-stat-card { background: #fff; border-radius: 14px; padding: 14px; }
    .mobile-stat-label { font-size: 11px; font-weight: 600; margin-bottom: 6px; text-transform: uppercase; }
    .mobile-stat-value { font-size: 16px; font-weight: 800; }
    .mobile-tx-card { background: #fff; border-radius: 12px; padding: 14px 16px; display: flex; align-items: center; gap: 12px; margin-bottom: 8px; }
    .mobile-tx-icon { width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .mobile-tx-info { flex: 1; min-width: 0; }
    .mobile-tx-name { font-size: 14px; font-weight: 600; color: #1E293B; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .mobile-tx-sub { font-size: 12px; color: #94A3B8; margin-top: 2px; }
    .mobile-tx-amount { font-size: 14px; font-weight: 700; flex-shrink: 0; }
    .mobile-bottom-nav { position: fixed; bottom: 0; left: 50%; transform: translateX(-50%); width: 100%; max-width: 480px; height: 68px; background: #fff; border-top: 1px solid #E2E8F0; display: flex; align-items: center; justify-content: space-around; z-index: 1000; box-shadow: 0 -4px 20px rgba(0,0,0,0.08); }
    .mobile-nav-item { display: flex; flex-direction: column; align-items: center; gap: 3px; padding: 8px 12px; text-decoration: none; color: #94A3B8; flex: 1; }
    .mobile-nav-item svg { width: 22px; height: 22px; }
    .mobile-nav-item span { font-size: 10px; font-weight: 500; }
    .mobile-nav-item.active { color: #014BAA; }
    .mobile-modal-overlay { display: none; position: fixed; inset: 0; background: rgba(15,23,42,0.6); backdrop-filter: blur(4px); z-index: 9999; align-items: flex-end; justify-content: center; }
    .mobile-modal-sheet { background: #fff; border-radius: 24px 24px 0 0; padding: 12px 20px 40px; width: 100%; max-width: 480px; max-height: 90vh; overflow-y: auto; }
    .mobile-modal-handle { width: 40px; height: 4px; background: #E2E8F0; border-radius: 99px; margin: 0 auto 16px; }
    .mobile-form-group { margin-bottom: 16px; }
    .mobile-label { display: block; font-size: 13px; font-weight: 600; color: #1E293B; margin-bottom: 6px; }
    .mobile-input, .mobile-select { width: 100%; padding: 12px 14px; border: 1.5px solid #E2E8F0; border-radius: 10px; font-size: 14px; color: #1E293B; background: #fff; outline: none; font-family: inherit; }
    .mobile-input:focus, .mobile-select:focus { border-color: #014BAA; }
    .mobile-btn { display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 14px; border-radius: 12px; font-size: 15px; font-weight: 700; border: none; cursor: pointer; font-family: inherit; text-decoration: none; }
    .mobile-btn-primary { background: #014BAA; color: #fff; }
    .mobile-btn-green { background: #22C55E; color: #fff; }
    .mobile-btn-red { background: #EF4444; color: #fff; }
    .mobile-btn-white { background: #fff; color: #1E293B; border: 1.5px solid #E2E8F0; margin-top: 8px; }
    .mobile-toast { position: fixed; top: 16px; left: 50%; transform: translateX(-50%); background: #1E293B; color: #fff; padding: 10px 16px; border-radius: 99px; font-size: 13px; font-weight: 500; z-index: 9999; white-space: nowrap; box-shadow: 0 4px 16px rgba(0,0,0,0.2); }
    .mobile-empty { text-align: center; padding: 40px 20px; color: #94A3B8; }
    .mobile-tab-bar { display: flex; background: #E8F0FB; border-radius: 12px; padding: 4px; margin: 0 16px 16px; }
    .mobile-tab { flex: 1; text-align: center; padding: 9px; border-radius: 9px; font-size: 13px; font-weight: 600; color: #64748B; text-decoration: none; }
    .mobile-tab.active { background: #014BAA; color: #fff; }
    .mobile-page-header { background: linear-gradient(135deg, #014BAA 0%, #0166E8 100%); padding: 16px 20px 20px; display: flex; align-items: center; gap: 12px; }
    .mobile-back-btn { width: 36px; height: 36px; border-radius: 10px; background: rgba(255,255,255,0.15); border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; }
    .mobile-page-title { font-size: 18px; font-weight: 700; color: #fff; }
    .mobile-card { background: #fff; border-radius: 16px; overflow: hidden; margin-bottom: 12px; }
    .mobile-card-body { padding: 16px; }
    .mobile-account-scroll { display: flex; gap: 12px; overflow-x: auto; padding: 0 16px 8px; scrollbar-width: none; }
    .mobile-account-scroll::-webkit-scrollbar { display: none; }
    .mobile-account-card { background: linear-gradient(135deg, #014BAA 0%, #0166E8 100%); border-radius: 16px; padding: 18px; color: #fff; min-width: 240px; flex-shrink: 0; }
    @supports (padding-bottom: env(safe-area-inset-bottom)) {
        .mobile-bottom-nav { padding-bottom: env(safe-area-inset-bottom); height: calc(68px + env(safe-area-inset-bottom)); }
        .mobile-main { padding-bottom: calc(80px + env(safe-area-inset-bottom)); }
    }
        /* Safe area override — berlaku untuk semua halaman yang pakai mobile-layout */
    .mobile-page-header {
        padding-top: max(16px, calc(env(safe-area-inset-top, 0px) + 14px)) !important;
    }
    .mobile-header {
        padding-top: max(20px, calc(env(safe-area-inset-top, 0px) + 16px)) !important;
    }
</style>
    @vite(['resources/css/app.css', 'resources/css/mobile.css', 'resources/js/app.js'])
</head>
<body class="mobile-body">
    <div class="mobile-app">
        <main class="mobile-main">
            @if (session('success'))
                <div class="mobile-toast" id="mobile-toast">✓ {{ session('success') }}</div>
            @endif
            {{ $slot }}
        </main>

        <nav class="mobile-bottom-nav">
            @php
            $navItems = [
                ['route' => 'dashboard',        'label' => 'Home',     'pattern' => 'dashboard',     'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
                ['route' => 'categories.index', 'label' => 'Kategori', 'pattern' => 'categories.*', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>'],
                ['route' => 'accounts.index',   'label' => 'Rekening', 'pattern' => 'accounts.*',    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>'],
                ['route' => 'reports.index',    'label' => 'Laporan',  'pattern' => 'reports.*',     'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>'],
                ['route' => 'profile.edit',     'label' => 'Profil',   'pattern' => 'profile.*',     'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>'],
            ];
            @endphp
            @foreach ($navItems as $nav)
                <a href="{{ route($nav['route']) }}"
                   class="mobile-nav-item {{ request()->routeIs($nav['pattern']) ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        {!! $nav['icon'] !!}
                    </svg>
                    <span>{{ $nav['label'] }}</span>
                </a>
            @endforeach
        </nav>
    </div>

    <script>
        const toast = document.getElementById('mobile-toast');
        if (toast) {
            setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 300); }, 3000);
        }
        if ('serviceWorker' in navigator) navigator.serviceWorker.register('/sw.js').catch(() => {});
    </script>
    @stack('scripts')
</body>
</html>
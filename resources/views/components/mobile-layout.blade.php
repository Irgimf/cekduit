@props(['title' => config('app.name')])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#014BAA">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="manifest" href="/manifest.json">
    <title>{{ $title }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet"/>
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
                ['route' => 'transactions.index','label' => 'Transaksi','pattern' => 'transactions.*','icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>'],
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
@props(['title' => config('app.name')])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#014BAA">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="CekDuit">
    <link rel="manifest" href="/manifest.json">
    <title>{{ $title }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/css/mobile.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; margin: 0; padding: 0; }
        body { font-family: 'Figtree', -apple-system, sans-serif; }
        .mobile-input { width: 100%; padding: 12px 14px; border: 1.5px solid #E2E8F0; border-radius: 10px; font-size: 14px; color: #1E293B; background: #fff; outline: none; transition: border-color 0.15s; font-family: inherit; }
        .mobile-input:focus { border-color: #014BAA; }
        .mobile-label { display: block; font-size: 13px; font-weight: 600; color: #1E293B; margin-bottom: 6px; }
        .mobile-error { font-size: 12px; color: #EF4444; margin-top: 4px; }
        .mobile-btn { display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 14px; border-radius: 12px; font-size: 15px; font-weight: 700; border: none; cursor: pointer; font-family: inherit; text-decoration: none; }
        .mobile-btn-primary { background: #014BAA; color: #fff; }
        .mobile-btn-white { background: #fff; color: #1E293B; border: 1.5px solid #E2E8F0; }
        .mobile-form-group { margin-bottom: 14px; }
        .mobile-toast { position: fixed; top: 16px; left: 50%; transform: translateX(-50%); background: #1E293B; color: #fff; padding: 10px 16px; border-radius: 99px; font-size: 13px; font-weight: 500; z-index: 9999; white-space: nowrap; }
    </style>
</head>
<body>
    {{-- Tidak ada bottom nav di sini --}}
    {{ $slot }}
    @stack('scripts')
</body>
</html>
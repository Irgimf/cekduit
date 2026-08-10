<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CekDuit') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background: var(--cream); min-height: 100vh; display: flex; align-items: center; justify-content: center;">
    <div style="width: 100%; max-width: 440px; padding: 16px;">
        
        {{-- Logo Section --}}
        <div class="text-center mb-6">
            <a href="/" style="display:inline-flex;align-items:center;gap:10px;text-decoration:none;">
                <x-logo-icon size="40" radius="10" />
                <span style="font-size:22px;font-weight:800;color:var(--blue);">CekDuit</span>
            </a>
        </div>

        {{-- Card Content --}}
        <div class="cd-card" style="padding:32px;">
            {{ $slot }}
        </div>

        {{-- Footer --}}
        <p class="text-center mt-4" style="font-size:12px;color:var(--muted);">
            &copy; {{ date('Y') }} CekDuit. Kelola keuangan dengan mudah.
        </p>
    </div>
</body>
</html>

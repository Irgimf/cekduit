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
        {{-- Logo --}}
        <div class="text-center mb-6">
            <a href="/" style="display:inline-flex;align-items:center;gap:10px;text-decoration:none;">
                <div style="width:40px;height:40px;background:var(--blue);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span style="font-size:22px;font-weight:800;color:var(--blue);">CekDuit</span>
            </a>
        </div>

        <div class="cd-card" style="padding:32px;">
            {{ $slot }}
        </div>

        <p class="text-center mt-4" style="font-size:12px;color:var(--muted);">
            &copy; {{ date('Y') }} CekDuit. Kelola keuangan dengan mudah.
        </p>
    </div>
</body>
</html>
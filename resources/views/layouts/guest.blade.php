<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CekDuit') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background-color:#FFFBEB; min-height: 100vh;" class="flex flex-col items-center justify-center pt-6 sm:pt-0">
    <div class="mb-6">
        <a href="/" class="text-3xl font-black tracking-tight text-black">
            💰 CekDuit
        </a>
    </div>

    <div class="nb-card w-full sm:max-w-md px-8 py-8">
        {{ $slot }}
    </div>
</body>
</html>
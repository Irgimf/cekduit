<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CekDuit') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/dashboard.js'])
</head>
<body class="min-h-screen" style="background-color:#FFFBEB;">
    @include('layouts.navigation')

    @if (isset($header))
        <header style="border-bottom: 2px solid #000; background: #fff;">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <main>
        @if (session('success'))
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-4">
                <div class="nb-card p-3 font-bold text-sm"
                     style="background: #4ADE80;">
                    ✅ {{ session('success') }}
                </div>
            </div>
        @endif

        {{ $slot }}
    </main>

    @stack('scripts')
</body>
</html>
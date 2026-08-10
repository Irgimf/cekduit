@props([])
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#014BAA">
    <title>Setup Akun — CekDuit</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; -webkit-tap-highlight-color: transparent; }
        body { font-family: 'Figtree', -apple-system, sans-serif; background: #014BAA; min-height: 100vh; }
        .ob-wrap { max-width: 480px; margin: 0 auto; min-height: 100vh; display: flex; flex-direction: column; }
        .ob-header { padding: max(20px,calc(env(safe-area-inset-top,0px) + 16px)) 24px 20px; display: flex; align-items: center; justify-content: space-between; }
        .ob-logo { display: flex; align-items: center; gap: 8px; text-decoration: none; }
        .ob-logo-text { font-size: 18px; font-weight: 800; color: #fff; }
        .ob-skip { font-size: 13px; color: rgba(255,255,255,0.7); text-decoration: none; font-weight: 500; background: none; border: none; cursor: pointer; font-family: inherit; padding: 4px 8px; }
        .ob-steps { padding: 0 24px 24px; display: flex; align-items: center; gap: 6px; }
        .ob-step-dot { height: 4px; border-radius: 99px; background: rgba(255,255,255,0.25); flex: 1; transition: all 0.3s; }
        .ob-step-dot.active { background: #fff; }
        .ob-step-dot.done { background: rgba(255,255,255,0.6); }
        .ob-content { flex: 1; background: #F0F4F8; border-radius: 28px 28px 0 0; padding: 28px 24px calc(env(safe-area-inset-bottom,0px) + 32px); overflow-y: auto; }
        .ob-icon { width: 64px; height: 64px; border-radius: 18px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; }
        .ob-title { font-size: 22px; font-weight: 800; color: #1E293B; margin-bottom: 6px; }
        .ob-desc { font-size: 14px; color: #64748B; line-height: 1.6; margin-bottom: 28px; }
        .ob-label { display: block; font-size: 13px; font-weight: 600; color: #1E293B; margin-bottom: 7px; }
        .ob-input { width: 100%; padding: 14px 16px; border: 1.5px solid #E2E8F0; border-radius: 12px; font-size: 15px; color: #1E293B; background: #fff; outline: none; font-family: inherit; -webkit-appearance: none; transition: border-color 0.15s; }
        .ob-input:focus { border-color: #014BAA; }
        .ob-select { width: 100%; padding: 14px 16px; border: 1.5px solid #E2E8F0; border-radius: 12px; font-size: 15px; color: #1E293B; background: #fff; outline: none; font-family: inherit; -webkit-appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394A3B8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; background-size: 16px; padding-right: 36px; transition: border-color 0.15s; }
        .ob-select:focus { border-color: #014BAA; }
        .ob-btn { width: 100%; padding: 15px; border-radius: 14px; font-size: 16px; font-weight: 700; border: none; cursor: pointer; font-family: inherit; transition: opacity 0.15s; display: block; text-align: center; text-decoration: none; }
        .ob-btn:active { opacity: 0.85; }
        .ob-btn-primary { background: #014BAA; color: #fff; }
        .ob-btn-white { background: #fff; color: #1E293B; border: 1.5px solid #E2E8F0; }
        .ob-chip-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 8px; }
        .ob-chip { padding: 12px 14px; border: 2px solid #E2E8F0; border-radius: 12px; font-size: 14px; font-weight: 600; color: #64748B; background: #fff; cursor: pointer; text-align: center; transition: all 0.15s; user-select: none; }
        .ob-chip.selected { border-color: #014BAA; background: #E8F0FB; color: #014BAA; }
        .ob-form-group { margin-bottom: 16px; }
    </style>
</head>
<body>
<div class="ob-wrap">
    {{ $slot }}
</div>
@stack('scripts')
</body>
</html>

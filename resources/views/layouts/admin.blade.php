<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — CekDuit</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .admin-wrapper { display: flex; min-height: 100vh; background: #F0F4F8; }

        .admin-sidebar {
            width: 240px;
            min-height: 100vh;
            background: #0F172A;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
        }

        .admin-sidebar-logo {
            padding: 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-sidebar-logo-text {
            font-size: 16px;
            font-weight: 800;
            color: #fff;
        }

        .admin-sidebar-logo-sub {
            font-size: 10px;
            color: rgba(255,255,255,0.4);
            font-weight: 500;
        }

        .admin-nav { padding: 16px 12px; flex: 1; }

        .admin-nav-label {
            font-size: 10px;
            font-weight: 700;
            color: rgba(255,255,255,0.3);
            text-transform: uppercase;
            letter-spacing: .08em;
            padding: 0 8px;
            margin-bottom: 8px;
            margin-top: 16px;
        }

        .admin-nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            color: rgba(255,255,255,0.6);
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.15s;
            margin-bottom: 2px;
        }

        .admin-nav-link:hover { background: rgba(255,255,255,0.07); color: #fff; }
        .admin-nav-link.active { background: #014BAA; color: #fff; }

        .admin-nav-link svg { width: 18px; height: 18px; flex-shrink: 0; }

        .admin-sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        .admin-main {
            margin-left: 240px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .admin-topbar {
            height: 60px;
            background: #fff;
            border-bottom: 1px solid #E2E8F0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .admin-topbar-title {
            font-size: 17px;
            font-weight: 700;
            color: #0F172A;
        }

        .admin-content { padding: 28px; }

        .admin-stat-card {
            background: #fff;
            border-radius: 14px;
            padding: 20px 24px;
            border: 1px solid #E2E8F0;
        }

        .admin-stat-label {
            font-size: 12px;
            font-weight: 600;
            color: #64748B;
            text-transform: uppercase;
            letter-spacing: .05em;
            margin-bottom: 8px;
        }

        .admin-stat-value {
            font-size: 28px;
            font-weight: 800;
            color: #0F172A;
        }

        .admin-stat-sub {
            font-size: 12px;
            color: #94A3B8;
            margin-top: 4px;
        }

        .admin-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #E2E8F0;
            overflow: hidden;
        }

        .admin-card-header {
            padding: 16px 20px;
            border-bottom: 1px solid #E2E8F0;
            font-size: 15px;
            font-weight: 700;
            color: #0F172A;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .admin-table { width: 100%; border-collapse: collapse; }
        .admin-table th {
            padding: 11px 16px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #64748B;
            border-bottom: 1px solid #E2E8F0;
            text-align: left;
            background: #FAFBFC;
        }
        .admin-table td {
            padding: 13px 16px;
            font-size: 14px;
            border-bottom: 1px solid #F1F5F9;
            color: #0F172A;
        }
        .admin-table tr:last-child td { border-bottom: none; }
        .admin-table tr:hover td { background: #F8FAFF; }

        .role-badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 700;
        }
        .role-badge.admin   { background: #FEE2E2; color: #dc2626; }
        .role-badge.premium { background: #FEF9C3; color: #92400E; }
        .role-badge.user    { background: #F1F5F9; color: #64748B; }

        .admin-btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; border-radius: 8px; font-size: 13px;
            font-weight: 600; cursor: pointer; border: none;
            font-family: inherit; text-decoration: none; transition: all 0.15s;
        }
        .admin-btn:hover { opacity: 0.85; transform: translateY(-1px); }
        .admin-btn-primary { background: #014BAA; color: #fff; }
        .admin-btn-white   { background: #fff; color: #0F172A; border: 1px solid #E2E8F0; }
        .admin-btn-red     { background: #EF4444; color: #fff; }
        .admin-btn-sm      { padding: 5px 12px; font-size: 12px; border-radius: 6px; }

        .admin-input {
            padding: 9px 12px; border: 1.5px solid #E2E8F0; border-radius: 8px;
            font-size: 14px; color: #0F172A; background: #fff; outline: none;
            font-family: inherit; transition: border-color 0.15s;
        }
        .admin-input:focus { border-color: #014BAA; }

        .admin-select {
            padding: 9px 12px; border: 1.5px solid #E2E8F0; border-radius: 8px;
            font-size: 14px; color: #0F172A; background: #fff; outline: none;
            font-family: inherit; appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394A3B8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 10px center; background-size: 14px;
            padding-right: 32px;
        }
    </style>
</head>
<body style="margin:0;font-family:'Figtree',sans-serif;">
<div class="admin-wrapper">

    {{-- Sidebar --}}
    <aside class="admin-sidebar">
        <div class="admin-sidebar-logo">
            <div style="width:32px;height:32px;background:#014BAA;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="admin-sidebar-logo-text">CekDuit</div>
                <div class="admin-sidebar-logo-sub">Admin Panel</div>
            </div>
        </div>

        <nav class="admin-nav">
            <div class="admin-nav-label">Menu Utama</div>

            <a href="{{ route('admin.dashboard') }}"
               class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('admin.users.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Manajemen User
            </a>

            <a href="{{ route('admin.payments') }}"
                class="admin-nav-link {{ request()->routeIs('admin.payments*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    Pembayaran
                </a>

            <div class="admin-nav-label">Akses</div>

            <a href="{{ route('dashboard') }}"
               class="admin-nav-link">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                Kembali ke App
            </a>
        </nav>

        <div class="admin-sidebar-footer">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                <img src="{{ Auth::user()->avatar_url }}" alt="Avatar"
                     style="width:32px;height:32px;border-radius:50%;object-fit:cover;">
                <div>
                    <div style="font-size:13px;font-weight:600;color:#fff;">{{ Auth::user()->name }}</div>
                    <div style="font-size:11px;color:rgba(255,255,255,0.4);">Administrator</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="admin-nav-link" style="width:100%;cursor:pointer;background:none;border:none;text-align:left;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="admin-main">
        <div class="admin-topbar">
            <div class="admin-topbar-title">{{ $pageTitle ?? 'Admin Panel' }}</div>
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="font-size:12px;color:#64748B;">{{ now()->translatedFormat('l, d F Y') }}</span>
            </div>
        </div>

        <div class="admin-content">
            @if (session('success'))
                <div style="background:#DCFCE7;border:1px solid #BBF7D0;color:#15803d;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:14px;font-weight:500;">
                    ✓ {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div style="background:#FEE2E2;border:1px solid #FECACA;color:#dc2626;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:14px;font-weight:500;">
                    ✗ {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>
@stack('scripts')
</body>
</html>
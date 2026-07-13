<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CekDuit') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/dashboard.js'])
</head>
<body style="background:var(--cream);margin:0;">

<div class="app-wrapper">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="sidebar" id="sidebar">

        {{-- Logo --}}
        <a href="{{ route('dashboard') }}" class="sidebar-logo">
            <div style="width:32px;height:32px;background:var(--blue);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="sidebar-logo-text">CekDuit</span>
        </a>

        {{-- Nav Items --}}
        <nav class="sidebar-nav">
            @php
            $navItems = [
                [
                    'route' => 'dashboard',
                    'label' => 'Dashboard',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
                ],
                [
                    'route' => 'accounts.index',
                    'label' => 'Rekening',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>',
                ],
                [
                    'route' => 'categories.index',
                    'label' => 'Kategori',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>',
                ],
                [
                    'route' => 'transactions.index',
                    'label' => 'Transaksi',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>',
                ],
                [
                    'route' => 'reports.index',
                    'label' => 'Laporan',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>',
                ],
            ];
            @endphp

            @foreach ($navItems as $nav)
                @php
                    $pattern = str_replace('.index', '.*', $nav['route']);
                    $isActive = request()->routeIs($pattern);
                @endphp
                <a href="{{ route($nav['route']) }}"
                   class="sidebar-link {{ $isActive ? 'active' : '' }}"
                   title="{{ $nav['label'] }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        {!! $nav['icon'] !!}
                    </svg>
                    <span class="sidebar-link-label">{{ $nav['label'] }}</span>
                </a>
            @endforeach
        </nav>

        {{-- Tambahkan sebelum link profil --}}
        @if (auth()->user()->isFree())
            <a href="{{ route('premium.upgrade') }}"
            style="display:flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;background:#FEF9C3;color:#92400E;font-size:13px;font-weight:600;text-decoration:none;border:1px solid #FDE68A;transition:all 0.15s;"
            onmouseover="this.style.background='#FDE68A'"
            onmouseout="this.style.background='#FEF9C3'">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l14 9-14 9V3z"/>
                </svg>
                Upgrade Premium
            </a>
        @else
            <span style="display:flex;align-items:center;gap:5px;padding:5px 12px;border-radius:8px;background:#DCFCE7;color:#15803d;font-size:12px;font-weight:700;">
                ⭐ Premium
            </span>
        @endif

        {{-- Footer Sidebar: Profile & Logout --}}
        <div class="sidebar-footer">
            <a href="{{ route('profile.edit') }}"
               class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}"
               title="Profil">
                <img src="{{ Auth::user()->avatar_url }}" alt="Avatar"
                     style="width:20px;height:20px;border-radius:50%;object-fit:cover;flex-shrink:0;">
                <span class="sidebar-link-label" style="font-size:13px;">{{ Auth::user()->name }}</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link" style="width:100%;background:none;border:none;cursor:pointer;text-align:left;" title="Keluar">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span class="sidebar-link-label">Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Mobile overlay --}}
    <div class="sidebar-overlay" id="sidebar-overlay" onclick="closeMobileSidebar()"></div>

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="main-content" id="main-content">

    {{-- Topbar --}}
    <div class="topbar" style="padding: 10px 32px 10px 24px;">
        <div class="topbar-left">
            <button class="topbar-toggle" id="sidebar-toggle" onclick="toggleSidebar()">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div>
                <div class="topbar-date" id="topbar-date"></div>
                @if (isset($header))
                    <div style="font-size:18px;font-weight:700;color:var(--dark);line-height:1.2;margin-top:1px;">
                        {{ $header }}
                    </div>
                @endif
            </div>
        </div>

        {{-- User info — beri margin kanan supaya tidak mentok --}}
        <div style="display:flex;align-items:center;gap:10px;margin-right:8px;">
            <a href="{{ route('profile.edit') }}"
            style="display:flex;align-items:center;gap:8px;text-decoration:none;padding:6px 14px;border-radius:99px;border:1.5px solid var(--border);background:var(--white);transition:all 0.15s;"
            onmouseover="this.style.borderColor='var(--blue)'"
            onmouseout="this.style.borderColor='var(--border)'">
                <img src="{{ Auth::user()->avatar_url }}" alt="Avatar"
                    style="width:28px;height:28px;border-radius:50%;object-fit:cover;border:2px solid var(--blue-light);">
                <span style="font-size:14px;font-weight:600;color:var(--dark);">{{ Auth::user()->name }}</span>
            </a>
        </div>
    </div>

        {{-- Flash message --}}
        <div class="page-content">
            @if (session('success'))
                <div class="cd-flash-success" style="margin-bottom:20px;">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

                @if (session('upgrade_required'))
        <div style="background:#FEF9C3;border:1px solid #FDE68A;color:#92400E;padding:12px 16px;border-radius:8px;margin-bottom:16px;display:flex;align-items:center;justify-content:space-between;gap:12px;">
            <div style="display:flex;align-items:center;gap:8px;font-size:14px;font-weight:500;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                {{ session('upgrade_required') }}
            </div>
            <a href="{{ route('premium.upgrade') }}"
            style="flex-shrink:0;padding:6px 14px;background:#014BAA;color:#fff;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;">
                Upgrade Sekarang
            </a>
        </div>
    @endif

            {{ $slot }}
        </div>
    </div>
</div>

@stack('scripts')

<script>
    // ===== Sidebar Toggle =====
    const sidebar     = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const overlay     = document.getElementById('sidebar-overlay');

    // Restore state from localStorage
    const isMobile = () => window.innerWidth <= 768;
    let isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';

    function applyState() {
        if (isMobile()) {
            sidebar.classList.remove('collapsed');
            mainContent.classList.remove('collapsed');
        } else {
            if (isCollapsed) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('collapsed');
            } else {
                sidebar.classList.remove('collapsed');
                mainContent.classList.remove('collapsed');
            }
        }
    }

    function toggleSidebar() {
        if (isMobile()) {
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');
        } else {
            isCollapsed = !isCollapsed;
            localStorage.setItem('sidebar-collapsed', isCollapsed);
            applyState();
        }
    }

    function closeMobileSidebar() {
        sidebar.classList.remove('mobile-open');
        overlay.classList.remove('active');
    }

    applyState();
    window.addEventListener('resize', applyState);

    // ===== Tanggal & Hari =====
    const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

    function updateDate() {
        const now  = new Date();
        const day  = days[now.getDay()];
        const date = now.getDate();
        const month = months[now.getMonth()];
        const year = now.getFullYear();
        const el = document.getElementById('topbar-date');
        if (el) {
            el.innerHTML = `${day}, ${date} ${month} <strong>${year}</strong>`;
        }
    }

    updateDate();
    setInterval(updateDate, 60000);
</script>

</body>
</html>
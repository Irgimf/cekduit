<nav x-data="{ open: false }" class="cd-nav">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            {{-- Logo + Nav Links --}}
            <div class="flex items-center gap-6">
                <a href="{{ route('dashboard') }}"
                   style="display:flex;align-items:center;gap:8px;text-decoration:none;">
                    <div style="width:32px;height:32px;background:var(--blue);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span style="font-weight:800;font-size:18px;color:var(--blue);">CekDuit</span>
                </a>

                <div class="hidden sm:flex items-center gap-1">
                    @php
                    $navItems = [
                        ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
                        ['route' => 'accounts.index', 'label' => 'Rekening', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>'],
                        ['route' => 'categories.index', 'label' => 'Kategori', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>'],
                        ['route' => 'transactions.index', 'label' => 'Transaksi', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>'],
                        ['route' => 'reports.index', 'label' => 'Laporan', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>'],
                    ];
                    @endphp
                    @foreach ($navItems as $nav)
                        @php
                            $routePattern = str_replace('.index', '.*', $nav['route']);
                            $isActive = request()->routeIs($routePattern);
                        @endphp
                        <a href="{{ route($nav['route']) }}"
                           class="cd-nav-link {{ $isActive ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                {!! $nav['icon'] !!}
                            </svg>
                            {{ $nav['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- User Dropdown --}}
            <div class="hidden sm:flex items-center">
                <x-dropdown align="right" width="52">
                    <x-slot name="trigger">
                        <button style="display:flex;align-items:center;gap:8px;padding:6px 12px;border-radius:99px;border:1.5px solid var(--border);background:var(--white);cursor:pointer;transition:all 0.15s;" onmouseover="this.style.borderColor='var(--blue)'" onmouseout="this.style.borderColor='var(--border)'">
                            <img src="{{ Auth::user()->avatar_url }}" alt="Avatar"
                                 style="width:28px;height:28px;border-radius:50%;object-fit:cover;border:2px solid var(--blue-light);">
                            <span style="font-size:14px;font-weight:600;color:var(--dark);">{{ Auth::user()->name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;color:var(--muted);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div style="padding:8px 0;">
                            <x-dropdown-link :href="route('profile.edit')"
                                style="display:flex;align-items:center;gap:8px;padding:9px 16px;font-size:14px;font-weight:500;color:var(--dark);">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Profil Saya
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    style="display:flex;align-items:center;gap:8px;padding:9px 16px;font-size:14px;font-weight:500;color:var(--red);">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Keluar
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Mobile Hamburger --}}
            <button @click="open = !open" class="sm:hidden p-2 rounded-lg" style="color:var(--muted);">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path :class="{'hidden': open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path :class="{'hidden': !open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden"
         style="border-top:1px solid var(--border);background:var(--white);">
        <div class="px-4 py-3 space-y-1">
            @foreach ($navItems as $nav)
                @php $isActive = request()->routeIs(str_replace('.index', '.*', $nav['route'])); @endphp
                <a href="{{ route($nav['route']) }}"
                   class="cd-nav-link {{ $isActive ? 'active' : '' }}"
                   style="display:flex;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        {!! $nav['icon'] !!}
                    </svg>
                    {{ $nav['label'] }}
                </a>
            @endforeach
        </div>
        <div style="padding:12px 16px;border-top:1px solid var(--border);background:#FAFBFC;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                <img src="{{ Auth::user()->avatar_url }}" alt="Avatar"
                     style="width:36px;height:36px;border-radius:50%;object-fit:cover;">
                <div>
                    <div style="font-weight:700;font-size:14px;color:var(--dark);">{{ Auth::user()->name }}</div>
                    <div style="font-size:12px;color:var(--muted);">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div style="display:flex;gap:8px;">
                <a href="{{ route('profile.edit') }}" class="cd-btn cd-btn-white cd-btn-sm">Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="cd-btn cd-btn-red cd-btn-sm">Keluar</button>
                </form>
            </div>
        </div>
    </div>
</nav>
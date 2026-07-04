<nav x-data="{ open: false }" class="nb-nav" style="position: relative; z-index: 10;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="text-xl font-black tracking-tight text-black">
                    CekDuit
                </a>

                <div class="hidden sm:flex items-center gap-6">
                    @foreach ([
                        ['route' => 'dashboard', 'label' => 'Dashboard'],
                        ['route' => 'accounts.index', 'label' => 'Rekening'],
                        ['route' => 'categories.index', 'label' => 'Kategori'],
                        ['route' => 'transactions.index', 'label' => 'Transaksi'],
                        ['route' => 'reports.index', 'label' => 'Laporan'],
                    ] as $nav)
                        <a href="{{ route($nav['route']) }}"
                           class="nb-nav-link text-sm {{ request()->routeIs(str_replace('.index', '.*', $nav['route'])) ? 'active' : '' }}">
                            {{ $nav['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="hidden sm:flex items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="nb-btn nb-btn-dark px-3 py-1.5 text-sm flex items-center gap-2">
                            <img src="{{ Auth::user()->avatar_url }}" alt="Avatar"
                                 class="w-6 h-6 object-cover" style="border: 1px solid #fff;">
                            {{ Auth::user()->name }}
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="font-bold">
                            Profile
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="font-bold">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="nb-btn nb-btn-dark p-2">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden"
         style="border-top: 2px solid #000; background: #fff;">
        <div class="py-2 space-y-1 px-4">
            @foreach ([
                ['route' => 'dashboard', 'label' => 'Dashboard'],
                ['route' => 'accounts.index', 'label' => 'Rekening'],
                ['route' => 'categories.index', 'label' => 'Kategori'],
                ['route' => 'transactions.index', 'label' => 'Transaksi'],
                ['route' => 'reports.index', 'label' => 'Laporan'],
            ] as $nav)
                <a href="{{ route($nav['route']) }}"
                   class="block py-2 font-bold text-sm border-b border-gray-100">
                    {{ $nav['label'] }}
                </a>
            @endforeach
        </div>
        <div class="py-3 px-4 border-t-2 border-black">
            <div class="font-black">{{ Auth::user()->name }}</div>
            <div class="text-sm text-gray-600">{{ Auth::user()->email }}</div>
            <div class="mt-2 flex gap-2">
                <a href="{{ route('profile.edit') }}" class="nb-btn nb-btn-primary px-3 py-1 text-sm">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nb-btn nb-btn-dark px-3 py-1 text-sm">Log Out</button>
                </form>
            </div>
        </div>
    </div>
</nav>
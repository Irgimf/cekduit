<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;">
            <h1 class="cd-page-title">Rekening</h1>
            <a href="{{ route('accounts.create') }}" class="cd-btn cd-btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Rekening
            </a>
        </div>
    </x-slot>

    @if ($accounts->isEmpty())
        <div class="cd-card" style="padding:60px;text-align:center;">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:48px;height:48px;color:var(--border);margin:0 auto 12px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
            <p style="color:var(--muted);font-size:15px;font-weight:500;">Belum ada rekening</p>
            <a href="{{ route('accounts.create') }}" class="cd-btn cd-btn-primary" style="margin-top:16px;display:inline-flex;">
                Tambah Rekening Pertama
            </a>
        </div>
    @else
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px;">
            @foreach ($accounts as $account)
                <div class="account-card">
                    {{-- Header --}}
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:20px;">
                        <div>
                            <p style="font-size:12px;opacity:0.7;font-weight:500;margin-bottom:2px;">
                                {{ $account->type_label }}
                            </p>
                            <h3 style="font-size:18px;font-weight:700;">{{ $account->name }}</h3>
                        </div>
                        <div style="width:40px;height:40px;background:rgba(255,255,255,0.15);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            @if ($account->type === 'bank')
                                <svg xmlns="http://www.w3.org/2000/svg" style="width:22px;height:22px;" fill="none" viewBox="0 0 24 24" stroke="white">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                </svg>
                            @elseif ($account->type === 'e_wallet')
                                <svg xmlns="http://www.w3.org/2000/svg" style="width:22px;height:22px;" fill="none" viewBox="0 0 24 24" stroke="white">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" style="width:22px;height:22px;" fill="none" viewBox="0 0 24 24" stroke="white">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            @endif
                        </div>
                    </div>

                    {{-- Nomor Rekening / HP --}}
                    @if ($account->account_number)
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:16px;">
                            <p style="font-size:13px;opacity:0.85;letter-spacing:1px;">
                                {{ $account->account_number }}
                            </p>
                            <button
                                data-number="{{ $account->account_number }}"
                                onclick="copyAccountNumber(this)"
                                style="background:rgba(255,255,255,0.2);border:none;border-radius:6px;padding:4px 6px;cursor:pointer;color:#fff;display:flex;align-items:center;flex-shrink:0;"
                                title="Salin nomor">
                                <svg id="icon-copy-{{ $account->id }}" xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            </button>
                        </div>
                    @else
                        <p style="font-size:13px;opacity:0.5;margin-bottom:16px;">Tidak ada nomor</p>
                    @endif

                    {{-- Saldo --}}
                    <div style="background:rgba(255,255,255,0.12);border-radius:8px;padding:12px 14px;margin-bottom:14px;">
                        <p style="font-size:11px;opacity:0.7;font-weight:500;margin-bottom:3px;letter-spacing:.05em;">TOTAL SALDO</p>
                        <p style="font-size:22px;font-weight:800;">Rp {{ number_format($account->balance, 0, ',', '.') }}</p>
                    </div>

                    {{-- Admin Fee --}}
                    @if ($account->admin_fee > 0)
                        <div style="display:flex;align-items:center;gap:6px;margin-bottom:14px;opacity:0.8;">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p style="font-size:12px;">Admin: Rp {{ number_format($account->admin_fee, 0, ',', '.') }}/bulan</p>
                        </div>
                    @endif

                    {{-- Actions --}}
                    <div style="display:flex;gap:8px;position:relative;z-index:1;">
                        <a href="{{ route('accounts.edit', $account) }}"
                           style="flex:1;display:flex;align-items:center;justify-content:center;gap:6px;padding:8px;background:rgba(255,255,255,0.15);border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;transition:background 0.15s;"
                           onmouseover="this.style.background='rgba(255,255,255,0.25)'"
                           onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                        <form action="{{ route('accounts.destroy', $account) }}" method="POST"
                              onsubmit="return confirm('Hapus rekening ini? Semua transaksi terkait juga akan terhapus.')"
                              style="flex:1;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    style="width:100%;display:flex;align-items:center;justify-content:center;gap:6px;padding:8px;background:rgba(255,255,255,0.12);border-radius:8px;font-size:13px;font-weight:600;color:#fff;border:none;cursor:pointer;transition:background 0.15s;"
                                    onmouseover="this.style.background='rgba(239,68,68,0.45)'"
                                    onmouseout="this.style.background='rgba(255,255,255,0.12)'">
                                <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <script>
        function copyAccountNumber(btn) {
            const number = btn.getAttribute('data-number');
            navigator.clipboard.writeText(number).then(() => {
                const svg = btn.querySelector('svg');
                // Ganti ikon jadi centang
                svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>';
                btn.style.background = 'rgba(34,197,94,0.35)';

                setTimeout(() => {
                    // Kembalikan ikon copy
                    svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>';
                    btn.style.background = 'rgba(255,255,255,0.2)';
                }, 1500);
            });
        }
    </script>
</x-app-layout>
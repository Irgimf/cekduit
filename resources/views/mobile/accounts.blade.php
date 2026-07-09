<x-mobile-layout>
    <div class="mobile-page-header" style="justify-content:space-between;align-items:center;padding-top:max(16px, calc(env(safe-area-inset-top, 0px) + 14px));">
        <div class="mobile-page-title">Rekening</div>
        <a href="{{ route('accounts.create') }}"
           style="width:34px;height:34px;background:rgba(255,255,255,0.2);border-radius:10px;display:flex;align-items:center;justify-content:center;text-decoration:none;flex-shrink:0;">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="white">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
        </a>
    </div>

    {{-- Total saldo --}}
    <div style="padding:12px 16px;">
        <div style="background:#fff;border-radius:14px;padding:16px;text-align:center;">
            <div style="font-size:11px;font-weight:600;color:#94A3B8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:6px;">Total Saldo Semua Rekening</div>
            <div style="font-size:24px;font-weight:800;color:#014BAA;">
                Rp {{ number_format($accounts->sum('balance'), 0, ',', '.') }}
            </div>
        </div>
    </div>

    <div style="padding:0 16px;">

        {{-- Card Tambah --}}
        <a href="{{ route('accounts.create') }}"
           style="display:flex;align-items:center;gap:14px;padding:16px;background:#fff;border-radius:16px;border:2px dashed #E2E8F0;text-decoration:none;margin-bottom:10px;">
            <div style="width:46px;height:46px;background:#E8F0FB;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:22px;height:22px;color:#014BAA;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <div>
                <div style="font-size:14px;font-weight:700;color:#014BAA;">Tambah Rekening</div>
                <div style="font-size:12px;color:#94A3B8;margin-top:2px;">Dompet, Bank, atau E-Wallet</div>
            </div>
        </a>

        @foreach ($accounts as $account)
        <div style="background:linear-gradient(135deg,#014BAA,#0166E8);border-radius:16px;padding:18px;color:#fff;margin-bottom:12px;position:relative;overflow:hidden;">
            {{-- Dekorasi --}}
            <div style="position:absolute;top:-20px;right:-20px;width:100px;height:100px;border-radius:50%;background:rgba(255,255,255,0.06);pointer-events:none;"></div>
            <div style="position:absolute;bottom:-30px;left:-10px;width:120px;height:80px;border-radius:50%;background:rgba(255,255,255,0.04);pointer-events:none;"></div>

            {{-- Header card --}}
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:14px;position:relative;">
                <div>
                    <div style="font-size:11px;opacity:0.7;font-weight:500;margin-bottom:2px;">{{ $account->type_label }}</div>
                    <div style="font-size:17px;font-weight:700;">{{ $account->name }}</div>
                </div>
                <div style="width:36px;height:36px;background:rgba(255,255,255,0.15);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    @if ($account->type === 'bank')
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="white">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                        </svg>
                    @elseif ($account->type === 'e_wallet')
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="white">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="white">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    @endif
                </div>
            </div>

            {{-- Nomor rekening — PLAIN TEXT bukan link --}}
            @if ($account->account_number)
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;position:relative;">
                    <span style="font-size:13px;color:rgba(255,255,255,0.9);letter-spacing:1px;font-weight:500;">
                        {{ $account->account_number }}
                    </span>
                    <button onclick="copyNumber('{{ $account->account_number }}', this)"
                            style="background:rgba(255,255,255,0.2);border:none;border-radius:6px;padding:4px 8px;cursor:pointer;color:#fff;font-size:11px;font-weight:600;display:flex;align-items:center;gap:4px;flex-shrink:0;">
                        <svg id="icon-{{ $account->id }}" xmlns="http://www.w3.org/2000/svg" style="width:12px;height:12px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        Salin
                    </button>
                </div>
            @else
                <div style="font-size:13px;color:rgba(255,255,255,0.5);margin-bottom:12px;">Tidak ada nomor</div>
            @endif

            {{-- Saldo --}}
            <div style="background:rgba(255,255,255,0.12);border-radius:10px;padding:10px 12px;margin-bottom:12px;position:relative;">
                <div style="font-size:10px;opacity:0.7;font-weight:500;margin-bottom:2px;letter-spacing:.05em;">TOTAL SALDO</div>
                <div style="font-size:20px;font-weight:800;">Rp {{ number_format($account->balance, 0, ',', '.') }}</div>
            </div>

            @if ($account->admin_fee > 0)
                <div style="font-size:11px;opacity:0.75;margin-bottom:10px;position:relative;">
                    ℹ️ Admin: Rp {{ number_format($account->admin_fee, 0, ',', '.') }}/bulan
                </div>
            @endif

            {{-- Aksi --}}
            <div style="display:flex;gap:8px;position:relative;">
                <a href="{{ route('accounts.edit', $account) }}"
                   style="flex:1;display:flex;align-items:center;justify-content:center;padding:9px;background:rgba(255,255,255,0.18);border-radius:9px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                    Edit
                </a>
                <form action="{{ route('accounts.destroy', $account) }}" method="POST"
                      onsubmit="return confirm('Hapus rekening {{ $account->name }}?')" style="flex:1;">
                    @csrf @method('DELETE')
                    <button type="submit"
                            style="width:100%;display:flex;align-items:center;justify-content:center;padding:9px;background:rgba(239,68,68,0.3);border-radius:9px;font-size:13px;font-weight:600;color:#fff;border:none;cursor:pointer;">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <div style="height:16px;"></div>

    {{-- Toast copy --}}
    <div id="copy-toast"
         style="display:none;position:fixed;bottom:90px;left:50%;transform:translateX(-50%);background:#1E293B;color:#fff;padding:8px 16px;border-radius:99px;font-size:13px;font-weight:500;z-index:9999;white-space:nowrap;">
        ✓ Nomor disalin
    </div>

    @push('scripts')
    <script>
        function copyNumber(number, btn) {
            navigator.clipboard.writeText(number).then(() => {
                // Tampilkan toast
                const toast = document.getElementById('copy-toast');
                toast.style.display = 'block';
                setTimeout(() => { toast.style.display = 'none'; }, 2000);

                // Ubah teks tombol sementara
                const originalHTML = btn.innerHTML;
                btn.innerHTML = '✓ Disalin';
                btn.style.background = 'rgba(34,197,94,0.35)';
                setTimeout(() => {
                    btn.innerHTML = originalHTML;
                    btn.style.background = 'rgba(255,255,255,0.2)';
                }, 2000);
            }).catch(() => {
                // Fallback untuk browser lama
                const el = document.createElement('textarea');
                el.value = number;
                document.body.appendChild(el);
                el.select();
                document.execCommand('copy');
                document.body.removeChild(el);
            });
        }
    </script>
    @endpush
</x-mobile-layout>
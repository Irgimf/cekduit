<x-onboarding-layout>
    <div class="ob-header">
        <span></span>
    </div>

    <div class="ob-steps">
        <div class="ob-step-dot done"></div>
        <div class="ob-step-dot done"></div>
        <div class="ob-step-dot done"></div>
        <div class="ob-step-dot active"></div>
    </div>

    <div class="ob-content" style="display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;min-height:calc(100vh - 120px);">

        {{-- Animasi ceklis --}}
        <div style="width:100px;height:100px;background:linear-gradient(135deg,#22C55E,#16a34a);border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:24px;box-shadow:0 16px 40px rgba(34,197,94,0.3);animation:popIn 0.5s ease;">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:52px;height:52px;" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <div style="font-size:32px;margin-bottom:12px;"><x-heroicon-o-sparkles class="w-6 h-6 inline text-yellow-500" /></div>
        <div class="ob-title" style="text-align:center;font-size:26px;">Akun Siap!</div>
        <div class="ob-desc" style="text-align:center;max-width:280px;margin:8px auto 32px;">
            Setup selesai! Kamu sudah bisa mulai mencatat keuangan dengan CekDuit.
        </div>

        {{-- Ringkasan setup --}}
        <div style="background:#fff;border-radius:16px;padding:16px;width:100%;margin-bottom:28px;text-align:left;">
            <div style="font-size:13px;font-weight:700;color:#1E293B;margin-bottom:12px;">Yang sudah disiapkan:</div>
            <div style="display:flex;flex-direction:column;gap:8px;">
                @if (auth()->user()->accounts->isNotEmpty())
                <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:#64748B;">
                    <span style="width:22px;height:22px;background:#DCFCE7;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;color:#16a34a;font-weight:700;flex-shrink:0;"><x-heroicon-o-check class="w-5 h-5 inline text-green-500" /></span>
                    {{ auth()->user()->accounts->count() }} rekening ditambahkan
                </div>
                @endif
                @if (auth()->user()->categories->isNotEmpty())
                <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:#64748B;">
                    <span style="width:22px;height:22px;background:#DCFCE7;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;color:#16a34a;font-weight:700;flex-shrink:0;"><x-heroicon-o-check class="w-5 h-5 inline text-green-500" /></span>
                    {{ auth()->user()->categories->count() }} kategori dipilih
                </div>
                @endif
                @if (auth()->user()->transactions->isNotEmpty())
                <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:#64748B;">
                    <span style="width:22px;height:22px;background:#DCFCE7;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;color:#16a34a;font-weight:700;flex-shrink:0;"><x-heroicon-o-check class="w-5 h-5 inline text-green-500" /></span>
                    Transaksi pertama dicatat
                </div>
                @endif
            </div>
        </div>

        <form method="POST" action="{{ route('onboarding.complete') }}" style="width:100%;">
            @csrf
            <button type="submit" class="ob-btn ob-btn-primary" style="font-size:17px;">
                <x-heroicon-o-rocket-launch class="w-6 h-6 inline text-blue-500" /> Mulai Gunakan CekDuit
            </button>
        </form>
    </div>

    <style>
        @keyframes popIn {
            from { transform: scale(0); opacity: 0; }
            to   { transform: scale(1); opacity: 1; }
        }
    </style>
</x-onboarding-layout>

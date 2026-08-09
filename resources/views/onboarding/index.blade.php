<x-onboarding-layout>
    {{-- Header --}}
    <div class="ob-header">
        <a href="/" class="ob-logo">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512" style="border-radius:8px;">
                <rect width="512" height="512" rx="114" fill="rgba(255,255,255,0.2)"/>
                <circle cx="256" cy="256" r="175" fill="none" stroke="rgba(255,255,255,0.9)" stroke-width="28"/>
                <text x="256" y="310" font-family="Arial,sans-serif" font-weight="800" font-size="168" fill="white" text-anchor="middle">Rp</text>
            </svg>
            <span class="ob-logo-text">CekDuit</span>
        </a>
        <form method="POST" action="{{ route('onboarding.skip') }}">
            @csrf
            <button type="submit" class="ob-skip">Lewati</button>
        </form>
    </div>

    {{-- Progress --}}
    <div class="ob-steps">
        <div class="ob-step-dot active"></div>
        <div class="ob-step-dot"></div>
        <div class="ob-step-dot"></div>
        <div class="ob-step-dot"></div>
    </div>

    {{-- Content --}}
    <div class="ob-content">
        {{-- Ilustrasi --}}
        <div style="text-align:center;padding:20px 0 28px;">
            <div style="width:120px;height:120px;background:linear-gradient(135deg,#014BAA,#0166E8);border-radius:32px;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;box-shadow:0 16px 40px rgba(1,75,170,0.25);">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:60px;height:60px;" fill="none" viewBox="0 0 24 24" stroke="white">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ob-title" style="text-align:center;">Selamat Datang,<br>{{ auth()->user()->name }}! <x-heroicon-o-hand-raised class="w-6 h-6 inline text-yellow-500" /></div>
            <div class="ob-desc" style="text-align:center;margin-bottom:0;">
                Mari setup akun CekDuit kamu dalam<br>
                <strong style="color:#014BAA;">3 langkah mudah</strong> — hanya butuh 2 menit.
            </div>
        </div>

        {{-- Steps preview --}}
        <div style="display:flex;flex-direction:column;gap:12px;margin-bottom:28px;">
            @foreach ([
                ['<x-heroicon-o-building-library class="w-6 h-6 inline text-blue-500" />', '#E8F0FB', '#014BAA', 'Langkah 1', 'Tambah rekening pertamamu', 'Dompet, bank, atau e-wallet'],
                ['<x-heroicon-o-tag class="w-5 h-5 inline text-blue-500" />️', '#DCFCE7', '#16a34a', 'Langkah 2', 'Pilih kategori', 'Pengeluaran dan pemasukan'],
                ['<x-heroicon-o-currency-dollar class="w-6 h-6 inline text-green-500" />', '#FEF9C3', '#ca8a04', 'Langkah 3', 'Catat transaksi pertama', 'Opsional, bisa dilewati'],
            ] as [$emoji, $bg, $color, $step, $title, $desc])
            <div style="background:#fff;border-radius:14px;padding:14px 16px;display:flex;align-items:center;gap:14px;">
                <div style="width:44px;height:44px;background:{{ $bg }};border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">
                    {{ $emoji }}
                </div>
                <div>
                    <div style="font-size:11px;font-weight:600;color:{{ $color }};text-transform:uppercase;letter-spacing:.04em;margin-bottom:2px;">{{ $step }}</div>
                    <div style="font-size:14px;font-weight:700;color:#1E293B;">{{ $title }}</div>
                    <div style="font-size:12px;color:#94A3B8;margin-top:1px;">{{ $desc }}</div>
                </div>
            </div>
            @endforeach
        </div>

        <a href="{{ route('onboarding.step', 'account') }}"
           class="ob-btn ob-btn-primary"
           style="display:block;text-align:center;text-decoration:none;">
            Mulai Setup →
        </a>
    </div>
</x-onboarding-layout>
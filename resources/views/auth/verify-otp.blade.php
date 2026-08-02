@if (config('is_mobile'))
<x-mobile-auth-layout>
<div style="min-height:100vh;display:flex;flex-direction:column;background:#014BAA;">

    {{-- Area Logo --}}
    <div style="flex:0 0 auto;display:flex;flex-direction:column;align-items:center;justify-content:center;
                padding-top:max(48px, calc(env(safe-area-inset-top,0px) + 32px));
                padding-bottom:28px;">
        <div style="margin-bottom:14px;">
            {{-- Ikon email / verifikasi --}}
            <div style="width:72px;height:72px;background:rgba(255,255,255,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid rgba(255,255,255,0.5);">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:36px;height:36px;" fill="none" viewBox="0 0 24 24" stroke="white">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
        <div style="font-size:22px;font-weight:800;color:#fff;">Verifikasi Email</div>
        <div style="font-size:13px;color:rgba(255,255,255,0.75);margin-top:4px;">Kode OTP dikirim ke email kamu</div>
    </div>

    {{-- Form card --}}
    <div style="flex:1;background:#F0F4F8;border-radius:28px 28px 0 0;padding:28px 24px 40px;">

        @if (session('status'))
            <div style="background:#DCFCE7;color:#16a34a;padding:10px 14px;border-radius:10px;font-size:13px;margin-bottom:16px;">
                {{ session('status') }}
            </div>
        @endif

        <label style="display:block;font-size:14px;font-weight:600;color:#1E293B;margin-bottom:10px;text-align:center;">
            Masukkan Kode OTP 6 Digit
        </label>

        <form method="POST" action="{{ route('verification.verify') }}" style="display:flex;flex-direction:column;gap:16px;">
            @csrf
            <input id="otp_code" name="otp_code" type="text" maxlength="6" autofocus
                   style="width:100%;padding:18px;border:1.5px solid #E2E8F0;border-radius:14px;font-size:34px;font-weight:800;letter-spacing:16px;text-align:center;background:#fff;color:#1E293B;outline:none;font-family:inherit;-webkit-appearance:none;"
                   placeholder="000000"
                   onfocus="this.style.borderColor='#014BAA'"
                   onblur="this.style.borderColor='#E2E8F0'">
            @error('otp_code')
                <div style="font-size:12px;color:#EF4444;text-align:center;">{{ $message }}</div>
            @enderror

            <button type="submit"
                    style="width:100%;padding:15px;background:#014BAA;color:#fff;border:none;border-radius:14px;font-size:16px;font-weight:700;cursor:pointer;font-family:inherit;">
                Verifikasi Email
            </button>
        </form>

        <div x-data="{
                countdown: {{ $cooldownSeconds ?? 0 }},
                init() {
                    if (this.countdown > 0) {
                        const t = setInterval(() => { this.countdown--; if (this.countdown <= 0) clearInterval(t); }, 1000);
                    }
                }
             }" style="margin-top:16px;display:flex;flex-direction:column;gap:10px;">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" :disabled="countdown > 0"
                        style="width:100%;padding:13px;background:#fff;color:#014BAA;border:1.5px solid #E2E8F0;border-radius:14px;font-size:14px;font-weight:700;cursor:pointer;font-family:inherit;">
                    <span x-show="countdown <= 0">Kirim Ulang OTP</span>
                    <span x-show="countdown > 0">Tunggu <span x-text="countdown"></span> detik</span>
                </button>
            </form>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        style="width:100%;background:none;border:none;color:#94A3B8;font-size:13px;padding:8px;cursor:pointer;font-family:inherit;">
                    Keluar dari akun ini
                </button>
            </form>
        </div>
    </div>
</div>
</x-mobile-auth-layout>

@else

<x-guest-layout>
    <div style="text-align:center;margin-bottom:24px;">
        <div style="width:56px;height:56px;background:var(--blue-light);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:28px;height:28px;color:var(--blue);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <h2 style="font-size:20px;font-weight:700;color:var(--dark);margin-bottom:4px;">Verifikasi Email</h2>
        <p style="font-size:14px;color:var(--muted);">Masukkan kode OTP 6 digit yang dikirim ke email kamu</p>
    </div>
    @if (session('status'))
        <div class="cd-flash-success" style="margin-bottom:16px;">{{ session('status') }}</div>
    @endif
    <form method="POST" action="{{ route('verification.verify') }}" style="display:flex;flex-direction:column;gap:16px;">
        @csrf
        <div>
            <label class="cd-label" style="text-align:center;display:block;">Kode OTP</label>
            <input id="otp_code" name="otp_code" type="text" maxlength="6" autofocus
                   class="cd-input" style="text-align:center;font-size:28px;font-weight:700;letter-spacing:12px;padding:14px;" placeholder="000000">
            @error('otp_code') <p class="cd-error" style="text-align:center;">{{ $message }}</p> @enderror
        </div>
        <button type="submit" class="cd-btn cd-btn-primary" style="justify-content:center;padding:11px;">Verifikasi Email</button>
    </form>
    <div x-data="{countdown:{{ $cooldownSeconds??0 }},init(){if(this.countdown>0){const t=setInterval(()=>{this.countdown--;if(this.countdown<=0)clearInterval(t);},1000);}}}" style="margin-top:16px;display:flex;flex-direction:column;gap:8px;">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" :disabled="countdown>0" class="cd-btn cd-btn-white" style="width:100%;justify-content:center;">
                <span x-show="countdown<=0">Kirim Ulang OTP</span>
                <span x-show="countdown>0">Kirim ulang dalam <span x-text="countdown"></span> detik</span>
            </button>
        </form>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="cd-btn cd-btn-ghost" style="width:100%;justify-content:center;font-size:13px;">Keluar</button>
        </form>
    </div>
</x-guest-layout>

@endif

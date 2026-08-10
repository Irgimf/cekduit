@if (config('is_mobile'))
<x-mobile-auth-layout>
<div style="min-height:100vh;display:flex;flex-direction:column;background:#014BAA;">

    {{-- Area Logo --}}
    <div style="flex:0 0 auto;display:flex;flex-direction:column;align-items:center;justify-content:center;
                padding-top:max(48px, calc(env(safe-area-inset-top,0px) + 32px));
                padding-bottom:28px;">
        <div style="margin-bottom:14px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" viewBox="0 0 512 512">
                <rect width="512" height="512" rx="114" fill="rgba(255,255,255,0.15)"/>
                <circle cx="256" cy="256" r="175" fill="none" stroke="rgba(255,255,255,0.9)" stroke-width="28"/>
                <text x="256" y="310" font-family="Arial,sans-serif" font-weight="800" font-size="168" fill="white" text-anchor="middle">Rp</text>
            </svg>
        </div>
        <div style="font-size:26px;font-weight:800;color:#fff;letter-spacing:-0.5px;">CekDuit</div>
        <div style="font-size:13px;color:rgba(255,255,255,0.75);margin-top:4px;">Mulai kelola keuangan kamu</div>
    </div>

    {{-- Form card --}}
    <div style="flex:1;background:#F0F4F8;border-radius:28px 28px 0 0;padding:28px 24px calc(env(safe-area-inset-bottom,0px) + 40px);overflow-y:auto;">

        <h2 style="font-size:22px;font-weight:800;color:#1E293B;margin-bottom:4px;text-align:center;">Buat Akun Baru</h2>
        <p style="font-size:13px;color:#94A3B8;margin-bottom:24px;text-align:center;">Gratis dan mudah digunakan</p>

        <form method="POST" action="{{ route('register') }}" style="display:flex;flex-direction:column;gap:0;">
            @csrf

            {{-- Nama --}}
            <div style="margin-bottom:14px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:7px;">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                       style="width:100%;padding:14px 16px;border:1.5px solid #E2E8F0;border-radius:12px;font-size:15px;color:#1E293B;background:#fff;outline:none;font-family:inherit;-webkit-appearance:none;"
                       placeholder="Nama kamu"
                       onfocus="this.style.borderColor='#014BAA'"
                       onblur="this.style.borderColor='#E2E8F0'">
                @error('name') <div style="font-size:12px;color:#EF4444;margin-top:4px;">{{ $message }}</div> @enderror
            </div>

            {{-- Email --}}
            <div style="margin-bottom:14px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:7px;">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       style="width:100%;padding:14px 16px;border:1.5px solid #E2E8F0;border-radius:12px;font-size:15px;color:#1E293B;background:#fff;outline:none;font-family:inherit;-webkit-appearance:none;"
                       placeholder="nama@email.com"
                       onfocus="this.style.borderColor='#014BAA'"
                       onblur="this.style.borderColor='#E2E8F0'">
                @error('email') <div style="font-size:12px;color:#EF4444;margin-top:4px;">{{ $message }}</div> @enderror
            </div>

            {{-- Password --}}
            <div style="margin-bottom:14px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:7px;">Password</label>
                <input type="password" name="password" required
                       style="width:100%;padding:14px 16px;border:1.5px solid #E2E8F0;border-radius:12px;font-size:15px;color:#1E293B;background:#fff;outline:none;font-family:inherit;-webkit-appearance:none;"
                       placeholder="Min. 8 karakter"
                       onfocus="this.style.borderColor='#014BAA'"
                       onblur="this.style.borderColor='#E2E8F0'">
                @error('password') <div style="font-size:12px;color:#EF4444;margin-top:4px;">{{ $message }}</div> @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div style="margin-bottom:18px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:7px;">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required
                       style="width:100%;padding:14px 16px;border:1.5px solid #E2E8F0;border-radius:12px;font-size:15px;color:#1E293B;background:#fff;outline:none;font-family:inherit;-webkit-appearance:none;"
                       placeholder="Ulangi password"
                       onfocus="this.style.borderColor='#014BAA'"
                       onblur="this.style.borderColor='#E2E8F0'">
            </div>

            {{-- Checkbox Syarat & Ketentuan --}}
            <div style="background:#fff;border-radius:12px;padding:14px 14px;margin-bottom:20px;border:1.5px solid #E2E8F0;">
                <label style="display:flex;align-items:flex-start;gap:10px;cursor:pointer;">
                    <input type="checkbox" name="agree_terms" required
                           style="width:18px;height:18px;margin-top:1px;accent-color:#014BAA;flex-shrink:0;">
                    <span style="font-size:13px;color:#64748B;line-height:1.6;">
                        Saya menyetujui
                        <a href="{{ route('legal.terms') }}" target="_blank" style="color:#014BAA;font-weight:700;">Syarat & Ketentuan</a>
                        dan
                        <a href="{{ route('legal.privacy') }}" target="_blank" style="color:#014BAA;font-weight:700;">Kebijakan Privasi</a>
                        CekDuit
                    </span>
                </label>
            </div>

            {{-- Submit --}}
            <button type="submit"
                    style="width:100%;padding:15px;background:#014BAA;color:#fff;border:none;border-radius:14px;font-size:16px;font-weight:700;cursor:pointer;font-family:inherit;transition:opacity 0.15s;"
                    onmousedown="this.style.opacity='0.85'"
                    ontouchstart="this.style.opacity='0.85'"
                    onmouseup="this.style.opacity='1'"
                    ontouchend="this.style.opacity='1'">
                Buat Akun
            </button>
        </form>

        <p style="text-align:center;margin-top:22px;font-size:14px;color:#64748B;">
            Sudah punya akun?
            <a href="{{ route('login') }}" style="color:#014BAA;font-weight:700;text-decoration:none;">Masuk di sini</a>
        </p>
    </div>
</div>
</x-mobile-auth-layout>

@else
<x-guest-layout>
    <h2 style="font-size:20px;font-weight:700;color:var(--dark);margin-bottom:4px;">Buat Akun</h2>
    <p style="font-size:14px;color:var(--muted);margin-bottom:24px;">Mulai kelola keuangan kamu hari ini</p>
    <form method="POST" action="{{ route('register') }}" style="display:flex;flex-direction:column;gap:16px;">
        @csrf
        <div>
            <label class="cd-label">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus class="cd-input" placeholder="Nama kamu">
            @error('name') <p class="cd-error">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="cd-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="cd-input" placeholder="nama@email.com">
            @error('email') <p class="cd-error">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="cd-label">Password</label>
            <input type="password" name="password" required class="cd-input" placeholder="Min. 8 karakter">
            @error('password') <p class="cd-error">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="cd-label">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required class="cd-input" placeholder="Ulangi password">
        </div>
        <div style="background:#F8FAFF;border-radius:10px;padding:12px;border:1px solid #E2E8F0;">
            <label style="display:flex;align-items:flex-start;gap:10px;cursor:pointer;">
                <input type="checkbox" name="agree_terms" required style="width:15px;height:15px;margin-top:2px;accent-color:var(--blue);flex-shrink:0;">
                <span style="font-size:13px;color:var(--muted);line-height:1.6;">
                    Saya menyetujui
                    <a href="{{ route('legal.terms') }}" target="_blank" style="color:var(--blue);font-weight:600;">Syarat & Ketentuan</a>
                    dan
                    <a href="{{ route('legal.privacy') }}" target="_blank" style="color:var(--blue);font-weight:600;">Kebijakan Privasi</a>
                    CekDuit
                </span>
            </label>
        </div>
        <button type="submit" class="cd-btn cd-btn-primary" style="justify-content:center;padding:11px;">Buat Akun</button>
    </form>
    <p style="text-align:center;margin-top:20px;font-size:13px;color:var(--muted);">
        Sudah punya akun? <a href="{{ route('login') }}" style="color:var(--blue);font-weight:600;">Masuk di sini</a>
    </p>
</x-guest-layout>
@endif

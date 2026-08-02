@if (config('is_mobile'))
<x-mobile-auth-layout>
<div style="min-height:100vh;display:flex;flex-direction:column;background:#014BAA;">

    {{-- Area Logo -- centered --}}
    <div style="flex:0 0 auto;display:flex;flex-direction:column;align-items:center;justify-content:center;
                padding-top:max(56px, calc(env(safe-area-inset-top,0px) + 40px));
                padding-bottom:36px;">
        {{-- Logo icon dengan lingkaran --}}
        <div style="margin-bottom:16px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 512 512">
                <rect width="512" height="512" rx="114" fill="rgba(255,255,255,0.15)"/>
                <circle cx="256" cy="256" r="175" fill="none" stroke="rgba(255,255,255,0.9)" stroke-width="28"/>
                <text x="256" y="310" font-family="Arial,sans-serif" font-weight="800" font-size="168" fill="white" text-anchor="middle">Rp</text>
            </svg>
        </div>
        <div style="font-size:28px;font-weight:800;color:#fff;letter-spacing:-0.5px;">CekDuit</div>
        <div style="font-size:14px;color:rgba(255,255,255,0.75);margin-top:4px;">Kelola keuangan dengan mudah</div>
    </div>

    {{-- Form card -- mengisi sisa layar --}}
    <div style="flex:1;background:#F0F4F8;border-radius:28px 28px 0 0;padding:28px 24px 40px;overflow-y:auto;">

        <h2 style="font-size:22px;font-weight:800;color:#1E293B;margin-bottom:4px;text-align:center;">Selamat Datang</h2>
        <p style="font-size:13px;color:#94A3B8;margin-bottom:28px;text-align:center;">Masuk ke akun CekDuit kamu</p>

        @if (session('status'))
            <div style="background:#DCFCE7;color:#16a34a;padding:10px 14px;border-radius:10px;font-size:13px;font-weight:500;margin-bottom:16px;">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="background:#FEE2E2;color:#dc2626;padding:10px 14px;border-radius:10px;font-size:13px;font-weight:500;margin-bottom:16px;">
                Email atau password salah.
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" style="display:flex;flex-direction:column;gap:0;">
            @csrf

            {{-- Email --}}
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:7px;">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       style="width:100%;padding:14px 16px;border:1.5px solid #E2E8F0;border-radius:12px;font-size:15px;color:#1E293B;background:#fff;outline:none;font-family:inherit;-webkit-appearance:none;transition:border-color 0.15s;"
                       placeholder="nama@email.com"
                       onfocus="this.style.borderColor='#014BAA'"
                       onblur="this.style.borderColor='#E2E8F0'">
            </div>

            {{-- Password --}}
            <div style="margin-bottom:20px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:7px;">
                    <label style="font-size:13px;font-weight:600;color:#1E293B;">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           style="font-size:12px;color:#014BAA;font-weight:600;text-decoration:none;">Lupa password?</a>
                    @endif
                </div>
                <input type="password" name="password" required
                       style="width:100%;padding:14px 16px;border:1.5px solid #E2E8F0;border-radius:12px;font-size:15px;color:#1E293B;background:#fff;outline:none;font-family:inherit;-webkit-appearance:none;transition:border-color 0.15s;"
                       placeholder="••••••••"
                       onfocus="this.style.borderColor='#014BAA'"
                       onblur="this.style.borderColor='#E2E8F0'">
            </div>

            {{-- Remember me --}}
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:24px;">
                <input type="checkbox" name="remember" id="remember_me"
                       style="width:18px;height:18px;accent-color:#014BAA;flex-shrink:0;border-radius:4px;">
                <label for="remember_me" style="font-size:14px;color:#64748B;cursor:pointer;">Ingat saya</label>
            </div>

            {{-- Submit --}}
            <button type="submit"
                    style="width:100%;padding:15px;background:#014BAA;color:#fff;border:none;border-radius:14px;font-size:16px;font-weight:700;cursor:pointer;font-family:inherit;letter-spacing:0.2px;transition:opacity 0.15s;"
                    onmousedown="this.style.opacity='0.85'"
                    ontouchstart="this.style.opacity='0.85'"
                    onmouseup="this.style.opacity='1'"
                    ontouchend="this.style.opacity='1'">
                Masuk
            </button>
        </form>

        @if (Route::has('register'))
            <p style="text-align:center;margin-top:24px;font-size:14px;color:#64748B;">
                Belum punya akun?
                <a href="{{ route('register') }}" style="color:#014BAA;font-weight:700;text-decoration:none;">Daftar sekarang</a>
            </p>
        @endif
    </div>
</div>
</x-mobile-auth-layout>

@else

<x-guest-layout>
    <h2 style="font-size:20px;font-weight:700;color:var(--dark);margin-bottom:4px;">Selamat Datang</h2>
    <p style="font-size:14px;color:var(--muted);margin-bottom:24px;">Masuk ke akun CekDuit kamu</p>

    @if (session('status'))
        <div class="cd-flash-success" style="margin-bottom:16px;">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" style="display:flex;flex-direction:column;gap:16px;">
        @csrf
        <div>
            <label class="cd-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="cd-input" placeholder="nama@email.com">
            @error('email') <p class="cd-error">{{ $message }}</p> @enderror
        </div>
        <div>
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:5px;">
                <label class="cd-label" style="margin:0;">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="font-size:12px;color:var(--blue);font-weight:500;">Lupa password?</a>
                @endif
            </div>
            <input type="password" name="password" required class="cd-input" placeholder="••••••••">
            @error('password') <p class="cd-error">{{ $message }}</p> @enderror
        </div>
        <div style="display:flex;align-items:center;gap:8px;">
            <input type="checkbox" name="remember" id="remember_me" style="width:15px;height:15px;accent-color:var(--blue);">
            <label for="remember_me" style="font-size:13px;color:var(--muted);">Ingat saya</label>
        </div>
        <button type="submit" class="cd-btn cd-btn-primary" style="justify-content:center;padding:11px;">
            Masuk
        </button>
    </form>

    @if (Route::has('register'))
        <p style="text-align:center;margin-top:20px;font-size:13px;color:var(--muted);">
            Belum punya akun?
            <a href="{{ route('register') }}" style="color:var(--blue);font-weight:600;">Daftar sekarang</a>
        </p>
    @endif
</x-guest-layout>

@endif

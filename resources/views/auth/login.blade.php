@if (config('is_mobile'))
<x-mobile-auth-layout>
    <div style="padding-top:max(56px, calc(env(safe-area-inset-top, 0px) + 24px));padding-left:32px;padding-right:32px;padding-bottom:32px;text-align:center;">
        <div class="mobile-auth-top" style="padding-left:32px;padding-right:32px;padding-bottom:32px;text-align:center;">
            <x-logo-icon size="72" radius="18" />
            <div style="font-size:26px;font-weight:800;color:#fff;">CekDuit</div>
            <div style="font-size:13px;color:rgba(255,255,255,0.75);margin-top:4px;">Kelola keuangan dengan mudah</div>
        </div>

        <div style="flex:1;background:#F0F4F8;border-radius:28px 28px 0 0;padding:28px 24px 40px;overflow-y:auto;">
            <h2 style="font-size:20px;font-weight:700;color:#1E293B;margin-bottom:4px;">Selamat Datang</h2>
            <p style="font-size:13px;color:#94A3B8;margin-bottom:24px;">Masuk ke akun CekDuit kamu</p>

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

            <form method="POST" action="{{ route('login') }}" style="display:flex;flex-direction:column;gap:14px;">
                @csrf
                <div class="mobile-form-group">
                    <label class="mobile-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="mobile-input" placeholder="nama@email.com">
                </div>

                <div class="mobile-form-group">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                        <label class="mobile-label" style="margin:0;">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               style="font-size:12px;color:#014BAA;font-weight:600;text-decoration:none;">Lupa password?</a>
                        @endif
                    </div>
                    <input type="password" name="password" required
                           class="mobile-input" placeholder="••••••••">
                </div>

                <div style="display:flex;align-items:center;gap:8px;">
                    <input type="checkbox" name="remember" id="remember_me"
                           style="width:16px;height:16px;accent-color:#014BAA;">
                    <label for="remember_me" style="font-size:13px;color:#64748B;">Ingat saya</label>
                </div>

                <button type="submit" class="mobile-btn mobile-btn-primary" style="margin-top:4px;">
                    Masuk
                </button>
            </form>

            @if (Route::has('register'))
                <p style="text-align:center;margin-top:20px;font-size:13px;color:#64748B;">
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

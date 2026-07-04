<x-guest-layout>
    <h2 style="font-size:20px;font-weight:700;color:var(--dark);margin-bottom:4px;">Selamat Datang</h2>
    <p style="font-size:14px;color:var(--muted);margin-bottom:24px;">Masuk ke akun CekDuit kamu</p>

    @if (session('status'))
        <div class="cd-flash-success mb-4">{{ session('status') }}</div>
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
                    <a href="{{ route('password.request') }}"
                       style="font-size:12px;color:var(--blue);font-weight:500;">Lupa password?</a>
                @endif
            </div>
            <input type="password" name="password" required class="cd-input" placeholder="••••••••">
            @error('password') <p class="cd-error">{{ $message }}</p> @enderror
        </div>

        <div style="display:flex;align-items:center;gap:8px;">
            <input type="checkbox" name="remember" id="remember_me"
                   style="width:15px;height:15px;accent-color:var(--blue);">
            <label for="remember_me" style="font-size:13px;color:var(--muted);">Ingat saya</label>
        </div>

        <button type="submit" class="cd-btn cd-btn-primary" style="justify-content:center;padding:11px;">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
            </svg>
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
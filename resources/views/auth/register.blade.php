<x-guest-layout>
    <h2 style="font-size:20px;font-weight:700;color:var(--dark);margin-bottom:4px;">Buat Akun</h2>
    <p style="font-size:14px;color:var(--muted);margin-bottom:24px;">Mulai kelola keuangan kamu hari ini</p>

    <form method="POST" action="{{ route('register') }}" style="display:flex;flex-direction:column;gap:16px;">
        @csrf

        <div>
            <label class="cd-label">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                   class="cd-input" placeholder="Nama kamu">
            @error('name') <p class="cd-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="cd-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="cd-input" placeholder="nama@email.com">
            @error('email') <p class="cd-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="cd-label">Password</label>
            <input type="password" name="password" required
                   class="cd-input" placeholder="Min. 8 karakter">
            @error('password') <p class="cd-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="cd-label">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required
                   class="cd-input" placeholder="Ulangi password">
        </div>

        <button type="submit" class="cd-btn cd-btn-primary" style="justify-content:center;padding:11px;">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            Buat Akun
        </button>
    </form>

    <p style="text-align:center;margin-top:20px;font-size:13px;color:var(--muted);">
        Sudah punya akun?
        <a href="{{ route('login') }}" style="color:var(--blue);font-weight:600;">Masuk di sini</a>
    </p>
</x-guest-layout>
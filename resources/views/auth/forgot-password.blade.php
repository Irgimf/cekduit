<x-guest-layout>
    <div style="text-align:center;margin-bottom:24px;">
        <div style="width:56px;height:56px;background:var(--blue-light);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:28px;height:28px;color:var(--blue);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
            </svg>
        </div>
        <h2 style="font-size:20px;font-weight:700;color:var(--dark);margin-bottom:4px;">Lupa Password</h2>
        <p style="font-size:14px;color:var(--muted);">Masukkan email dan kami akan kirimkan kode OTP</p>
    </div>

    <form method="POST" action="{{ route('password.email') }}" style="display:flex;flex-direction:column;gap:16px;">
        @csrf
        <div>
            <label class="cd-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="cd-input" placeholder="nama@email.com">
            @error('email') <p class="cd-error">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="cd-btn cd-btn-primary" style="justify-content:center;padding:11px;">
            Kirim Kode OTP
        </button>
    </form>

    <p style="text-align:center;margin-top:16px;">
        <a href="{{ route('login') }}" style="font-size:13px;color:var(--blue);font-weight:500;">
            ← Kembali ke Login
        </a>
    </p>
</x-guest-layout>
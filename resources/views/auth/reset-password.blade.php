<x-guest-layout>
    <h2 style="font-size:20px;font-weight:700;color:var(--dark);margin-bottom:4px;">Reset Password</h2>
    <p style="font-size:14px;color:var(--muted);margin-bottom:24px;">
        Kode OTP dikirim ke <strong>{{ $email }}</strong>
    </p>

    @if (session('status'))
        <div class="cd-flash-success mb-4">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" style="display:flex;flex-direction:column;gap:16px;">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">

        <div>
            <label class="cd-label" style="text-align:center;display:block;">Kode OTP</label>
            <input type="text" name="otp_code" maxlength="6" autofocus
                   class="cd-input" style="text-align:center;font-size:28px;font-weight:700;letter-spacing:12px;padding:14px;"
                   placeholder="000000">
            @error('otp_code') <p class="cd-error" style="text-align:center;">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="cd-label">Password Baru</label>
            <input type="password" name="password" required class="cd-input" placeholder="Min. 8 karakter">
            @error('password') <p class="cd-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="cd-label">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required class="cd-input" placeholder="Ulangi password baru">
        </div>

        <button type="submit" class="cd-btn cd-btn-primary" style="justify-content:center;padding:11px;">
            Reset Password
        </button>
    </form>

    <div x-data="{
            countdown: {{ $cooldownSeconds ?? 0 }},
            init() {
                if (this.countdown > 0) {
                    const t = setInterval(() => { this.countdown--; if (this.countdown <= 0) clearInterval(t); }, 1000);
                }
            }
         }" style="margin-top:12px;">
        <form method="POST" action="{{ route('password.otp.resend') }}">
            @csrf
            <button type="submit" :disabled="countdown > 0"
                    class="cd-btn cd-btn-white" style="width:100%;justify-content:center;">
                <span x-show="countdown <= 0">Kirim Ulang OTP</span>
                <span x-show="countdown > 0">Kirim ulang dalam <span x-text="countdown"></span> detik</span>
            </button>
        </form>
        <p style="text-align:center;margin-top:8px;">
            <a href="{{ route('login') }}" style="font-size:13px;color:var(--blue);">← Kembali ke Login</a>
        </p>
    </div>
</x-guest-layout>
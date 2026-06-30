<x-guest-layout>
    <h2 class="text-xl font-black mb-4">Verifikasi Email</h2>

    <p class="text-sm text-gray-600 mb-4">
        Kami sudah mengirimkan kode OTP 6 digit ke email kamu. Masukkan kodenya di bawah ini.
    </p>

    @if (session('status'))
        <div class="nb-card p-3 mb-4 text-sm font-bold" style="background: #4ADE80;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verification.verify') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-black mb-1">Kode OTP</label>
            <input id="otp_code" name="otp_code" type="text" maxlength="6" autofocus
                   class="nb-input w-full px-4 py-3 text-center text-3xl font-black tracking-widest"
                   placeholder="______">
            @error('otp_code')
                <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="nb-btn nb-btn-primary w-full py-2 font-black text-sm mb-4">
            Verifikasi
        </button>
    </form>

    {{-- Resend dengan countdown Alpine.js --}}
    <div x-data="{ 
            countdown: {{ $cooldownSeconds ?? 0 }},
            init() {
                if (this.countdown > 0) {
                    const timer = setInterval(() => {
                        this.countdown--;
                        if (this.countdown <= 0) clearInterval(timer);
                    }, 1000);
                }
            }
         }">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit"
                    :disabled="countdown > 0"
                    :class="countdown > 0 ? 'opacity-50 cursor-not-allowed' : 'nb-btn nb-btn-white'"
                    class="nb-btn nb-btn-white w-full py-2 text-sm font-black mb-2">
                <span x-show="countdown <= 0">Kirim Ulang Kode OTP</span>
                <span x-show="countdown > 0">Kirim ulang dalam <span x-text="countdown"></span> detik</span>
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nb-btn nb-btn-dark w-full py-2 text-sm font-black">
                Log Out
            </button>
        </form>
    </div>
</x-guest-layout>
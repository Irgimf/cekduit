<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Kami sudah mengirimkan kode OTP 6 digit ke email kamu. Masukkan kodenya di bawah ini untuk verifikasi akun.
    </div>

    @if (session('status'))
        <div class="mb-4 text-sm font-medium text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verification.verify') }}">
        @csrf

        <div>
            <x-input-label for="otp_code" value="Kode OTP" />
            <x-text-input id="otp_code" name="otp_code" type="text" maxlength="6"
                          class="mt-1 block w-full text-center text-2xl tracking-widest" autofocus />
            <x-input-error :messages="$errors->get('otp_code')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <x-primary-button>Verifikasi</x-primary-button>
        </div>
    </form>

    <form method="POST" action="{{ route('verification.send') }}" class="mt-4">
        @csrf
        <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
            Kirim ulang kode OTP
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="mt-4">
        @csrf
        <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
            Log Out
        </button>
    </form>
</x-guest-layout>
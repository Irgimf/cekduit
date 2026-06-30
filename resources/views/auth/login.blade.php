<x-guest-layout>
    <h2 class="text-xl font-black mb-6">Masuk ke Akun</h2>

    @if (session('status'))
        <div class="nb-card p-3 mb-4 text-sm font-bold" style="background: #4ADE80;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-black mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="nb-input w-full px-3 py-2 text-sm">
            @error('email') <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-black mb-1">Password</label>
            <input id="password" type="password" name="password" required
                   class="nb-input w-full px-3 py-2 text-sm">
            @error('password') <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4 flex items-center gap-2">
            <input type="checkbox" name="remember" id="remember_me"
                   class="nb-input w-4 h-4">
            <label for="remember_me" class="text-sm font-bold">Ingat saya</label>
        </div>

        <button type="submit" class="nb-btn nb-btn-primary w-full py-2 font-black text-sm mb-4">
             Masuk
        </button>

        <div class="flex flex-col gap-2 text-sm">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="font-bold underline">
                    Lupa password?
                </a>
            @endif
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="font-bold underline">
                    Belum punya akun? Daftar di sini →
                </a>
            @endif
        </div>
    </form>
</x-guest-layout>
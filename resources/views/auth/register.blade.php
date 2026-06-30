<x-guest-layout>
    <h2 class="text-xl font-black mb-6">Buat Akun Baru</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-black mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                   class="nb-input w-full px-3 py-2 text-sm">
            @error('name') <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-black mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="nb-input w-full px-3 py-2 text-sm">
            @error('email') <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-black mb-1">Password</label>
            <input type="password" name="password" required
                   class="nb-input w-full px-3 py-2 text-sm">
            @error('password') <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-black mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required
                   class="nb-input w-full px-3 py-2 text-sm">
        </div>

        <button type="submit" class="nb-btn nb-btn-primary w-full py-2 font-black text-sm mb-4">
            📝 Daftar Sekarang
        </button>

        <a href="{{ route('login') }}" class="text-sm font-bold underline">
            ← Sudah punya akun? Masuk
        </a>
    </form>
</x-guest-layout>
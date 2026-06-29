<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="p-4 sm:p-8 bg-white shadow-sm sm:rounded-lg mb-6">
    <section class="max-w-xl">
        <header>
            <h2 class="text-lg font-medium text-gray-900">Foto Profil</h2>
            <p class="mt-1 text-sm text-gray-600">Upload foto profil kamu (JPG/PNG, maks 2MB).</p>
        </header>

        <div class="flex items-center gap-4 mt-4">
            <img src="{{ auth()->user()->avatar_url }}" alt="Avatar"
                 class="w-16 h-16 rounded-full object-cover border border-gray-200">

            <form method="POST" action="{{ route('profile.avatar') }}" enctype="multipart/form-data" class="flex items-center gap-2">
                @csrf
                <input type="file" name="avatar" accept="image/png, image/jpeg"
                       class="text-sm text-gray-600">
                <button type="submit" class="px-3 py-1.5 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">
                    Upload
                </button>
            </form>
        </div>

        @error('avatar')
            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
        @enderror

        @if (session('status') === 'avatar-updated')
            <p class="text-green-600 text-sm mt-2">Foto profil berhasil diperbarui.</p>
        @endif
    </section>
</div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-900">Pengaturan Profil</h2>
    </x-slot>

    {{-- Cropper.js via CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Foto Profil --}}
            <div class="nb-card p-6">
                <h3 class="font-black text-lg mb-1">Foto Profil</h3>
                <p class="text-sm text-gray-600 mb-4">Pilih foto, atur posisi dan ukuran, lalu simpan.</p>

                @if (session('status') === 'avatar-updated')
                    <div class="nb-card p-3 mb-4 text-sm font-bold" style="background: #4ADE80;">
                        Foto profil berhasil diperbarui.
                    </div>
                @endif

                <div class="flex items-center gap-4 mb-4">
                    <img id="current_avatar" src="{{ auth()->user()->avatar_url }}" alt="Avatar"
                         class="w-20 h-20 object-cover"
                         style="border: 2px solid #000; box-shadow: 3px 3px 0 #000;">
                    <div>
                        <p class="font-black text-sm">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-gray-500 mb-2">{{ auth()->user()->email }}</p>
                        <label for="avatar_input"
                               class="nb-btn nb-btn-primary px-3 py-1.5 text-xs cursor-pointer inline-block">
                            Pilih Foto
                        </label>
                        <input type="file" id="avatar_input" accept="image/png,image/jpeg" class="hidden">
                    </div>
                </div>

                <form id="avatar_form" method="POST" action="{{ route('profile.avatar') }}">
                    @csrf
                    <input type="hidden" id="avatar_cropped" name="avatar_cropped">
                    <button type="submit" id="avatar_submit"
                            class="nb-btn nb-btn-dark px-4 py-2 text-sm hidden">
                        Simpan Foto
                    </button>
                </form>

                @error('avatar_cropped')
                    <p class="text-red-600 text-sm mt-2 font-bold">{{ $message }}</p>
                @enderror
            </div>

            {{-- Modal Crop --}}
            <div id="crop_modal"
                class="hidden fixed inset-0 flex items-center justify-center"
                style="background: rgba(0,0,0,0.75); z-index: 9999;">
                <div class="nb-card p-6 w-full max-w-lg mx-4">
                    <h3 class="font-black text-lg mb-3">Atur Foto Profil</h3>

                    <div class="mb-2 flex gap-4 text-xs font-bold text-gray-500">
                        <span>Drag = geser</span>
                        <span>Scroll = zoom</span>
                        <span>⤡ Tarik sudut = resize</span>
                    </div>

                    <div style="max-height: 360px; overflow: hidden; border: 2px solid #000;">
                        <img id="crop_preview" src="" alt="Preview" style="max-width: 100%; display: block;">
                    </div>

                    <div class="flex justify-end gap-2 mt-4">
                        <button id="crop_cancel" type="button"
                                class="nb-btn nb-btn-white px-4 py-2 text-sm">
                            Batal
                        </button>
                        <button id="crop_btn" type="button"
                                class="nb-btn nb-btn-primary px-4 py-2 text-sm">
                            Gunakan Foto Ini
                        </button>
                    </div>
                </div>
            </div>

            {{-- Informasi Profil --}}
            <div class="nb-card p-6">
                <h3 class="font-black text-lg mb-4">Informasi Profil</h3>
                @include('profile.partials.update-profile-information-form')
            </div>

            {{-- Update Password --}}
            <div class="nb-card p-6">
                <h3 class="font-black text-lg mb-4">Ubah Password</h3>
                @include('profile.partials.update-password-form')
            </div>

            {{-- Hapus Akun --}}
            <div class="nb-card p-6" style="border-color: #dc2626;">
                <h3 class="font-black text-lg mb-4" style="color: #dc2626;">⚠️ Hapus Akun</h3>
                @include('profile.partials.delete-user-form')
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Pindahkan modal ke akhir body supaya z-index pasti berfungsi
            const modalEl = document.getElementById('crop_modal');
            if (modalEl) {
                document.body.appendChild(modalEl);
            }
            const input       = document.getElementById('avatar_input');
            const preview     = document.getElementById('crop_preview');
            const modal       = document.getElementById('crop_modal');
            const cropBtn     = document.getElementById('crop_btn');
            const cancelBtn   = document.getElementById('crop_cancel');
            const croppedInput = document.getElementById('avatar_cropped');
            const submitBtn   = document.getElementById('avatar_submit');

            let cropper = null;

            // Saat user pilih file
            input.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = (event) => {
                    preview.src = event.target.result;
                    modal.classList.remove('hidden');

                    if (cropper) {
                        cropper.destroy();
                        cropper = null;
                    }

                    // Tunggu gambar load dulu sebelum init Cropper
                    preview.onload = () => {
                        cropper = new Cropper(preview, {
                            aspectRatio: 1,
                            viewMode: 2,
                            dragMode: 'move',
                            autoCropArea: 0.8,
                            restore: false,
                            guides: true,
                            center: true,
                            cropBoxMovable: true,
                            cropBoxResizable: true,
                            toggleDragModeOnDblclick: false,
                        });
                    };
                };
                reader.readAsDataURL(file);
            });

            // Tombol "Gunakan Foto Ini"
            cropBtn.addEventListener('click', () => {
                if (!cropper) return;

                cropper.getCroppedCanvas({
                    width: 300,
                    height: 300,
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high',
                }).toBlob((blob) => {
                    // Preview langsung berubah
                    const currentAvatar = document.getElementById('current_avatar');
                    if (currentAvatar) {
                        currentAvatar.src = URL.createObjectURL(blob);
                    }

                    // Konversi ke base64 untuk hidden input
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        croppedInput.value = e.target.result;
                        submitBtn.classList.remove('hidden');
                    };
                    reader.readAsDataURL(blob);

                    // Tutup modal
                    modal.classList.add('hidden');
                    cropper.destroy();
                    cropper = null;
                    input.value = '';

                }, 'image/jpeg', 0.9);
            });

            // Tombol Batal
            cancelBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }
                input.value = '';
            });

            // Tutup modal kalau klik area gelap di luar
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    cancelBtn.click();
                }
            });
        });
    </script>
</x-app-layout>
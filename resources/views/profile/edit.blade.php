<x-app-layout>
    <x-slot name="header">
        <h1 class="cd-page-title">Pengaturan Profil</h1>
    </x-slot>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

    <div style="max-width:640px;display:flex;flex-direction:column;gap:20px;">

        {{-- Foto Profil --}}
        <div class="cd-card" style="padding:28px;">
            <h3 style="font-size:16px;font-weight:700;color:var(--dark);margin-bottom:4px;">Foto Profil</h3>
            <p style="font-size:13px;color:var(--muted);margin-bottom:20px;">Upload foto, atur posisi dan ukuran, lalu simpan.</p>

            @if (session('status') === 'avatar-updated')
                <div class="cd-flash-success mb-4">Foto profil berhasil diperbarui.</div>
            @endif

            <div style="display:flex;align-items:center;gap:16px;">
                <img id="current_avatar" src="{{ auth()->user()->avatar_url }}" alt="Avatar"
                     style="width:72px;height:72px;border-radius:50%;object-fit:cover;border:3px solid var(--blue-light);">
                <div>
                    <p style="font-weight:700;font-size:15px;color:var(--dark);">{{ auth()->user()->name }}</p>
                    <p style="font-size:13px;color:var(--muted);margin-bottom:10px;">{{ auth()->user()->email }}</p>
                    <label for="avatar_input" class="cd-btn cd-btn-white cd-btn-sm" style="cursor:pointer;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Pilih Foto
                    </label>
                    <input type="file" id="avatar_input" accept="image/png,image/jpeg" class="hidden">
                </div>
            </div>

            <form id="avatar_form" method="POST" action="{{ route('profile.avatar') }}" style="margin-top:16px;">
                @csrf
                <input type="hidden" id="avatar_cropped" name="avatar_cropped">
                <button type="submit" id="avatar_submit"
                        class="cd-btn cd-btn-primary hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    Simpan Foto
                </button>
            </form>

            @error('avatar_cropped')
                <p class="cd-error" style="margin-top:8px;">{{ $message }}</p>
            @enderror
        </div>

        {{-- Modal Crop --}}
        <div id="crop_modal" class="hidden"
             style="position:fixed;inset:0;background:rgba(15,23,42,0.7);backdrop-filter:blur(4px);z-index:9999;display:none;align-items:center;justify-content:center;padding:16px;">
            <div class="cd-card" style="padding:24px;width:100%;max-width:520px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                    <h3 style="font-size:16px;font-weight:700;color:var(--dark);">Atur Foto Profil</h3>
                    <button id="crop_cancel" style="background:none;border:none;cursor:pointer;color:var(--muted);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <p style="font-size:12px;color:var(--muted);margin-bottom:10px;">Drag = geser &nbsp;·&nbsp; Scroll = zoom &nbsp;·&nbsp; Tarik sudut = resize</p>
                <div style="max-height:360px;overflow:hidden;border:1.5px solid var(--border);border-radius:8px;">
                    <img id="crop_preview" src="" alt="Preview" style="max-width:100%;display:block;">
                </div>
                <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:16px;">
                    <button id="crop_cancel_btn" class="cd-btn cd-btn-white">Batal</button>
                    <button id="crop_btn" class="cd-btn cd-btn-primary">Gunakan Foto Ini</button>
                </div>
            </div>
        </div>

        {{-- Informasi Profil --}}
        <div class="cd-card" style="padding:28px;">
            <h3 style="font-size:16px;font-weight:700;color:var(--dark);margin-bottom:20px;">Informasi Profil</h3>
            @include('profile.partials.update-profile-information-form')
        </div>

        {{-- Update Password --}}
        <div class="cd-card" style="padding:28px;">
            <h3 style="font-size:16px;font-weight:700;color:var(--dark);margin-bottom:20px;">Ubah Password</h3>
            @include('profile.partials.update-password-form')
        </div>

        {{-- Hapus Akun --}}
        <div class="cd-card" style="padding:28px;border-color:var(--red);">
            <h3 style="font-size:16px;font-weight:700;color:var(--red);margin-bottom:8px;">Hapus Akun</h3>
            <p style="font-size:13px;color:var(--muted);margin-bottom:16px;">Setelah dihapus, semua data tidak bisa dipulihkan.</p>
            @include('profile.partials.delete-user-form')
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('crop_modal');

            // Pindahkan modal ke body untuk menghindari z-index issue
            document.body.appendChild(modal);

            const input        = document.getElementById('avatar_input');
            const preview      = document.getElementById('crop_preview');
            const cropBtn      = document.getElementById('crop_btn');
            const cancelBtn    = document.getElementById('crop_cancel');
            const cancelBtn2   = document.getElementById('crop_cancel_btn');
            const croppedInput = document.getElementById('avatar_cropped');
            const submitBtn    = document.getElementById('avatar_submit');

            let cropper = null;

            const closeModal = () => {
                modal.style.display = 'none';
                if (cropper) { cropper.destroy(); cropper = null; }
                input.value = '';
            };

            input.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = (event) => {
                    preview.src = event.target.result;
                    modal.style.display = 'flex';

                    if (cropper) { cropper.destroy(); cropper = null; }

                    preview.onload = () => {
                        cropper = new Cropper(preview, {
                            aspectRatio: 1,
                            viewMode: 2,
                            dragMode: 'move',
                            autoCropArea: 0.8,
                            guides: true,
                            cropBoxMovable: true,
                            cropBoxResizable: true,
                        });
                    };
                };
                reader.readAsDataURL(file);
            });

            cropBtn.addEventListener('click', () => {
                if (!cropper) return;
                cropper.getCroppedCanvas({ width: 300, height: 300 }).toBlob((blob) => {
                    const currentAvatar = document.getElementById('current_avatar');
                    if (currentAvatar) currentAvatar.src = URL.createObjectURL(blob);

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        croppedInput.value = e.target.result;
                        submitBtn.classList.remove('hidden');
                    };
                    reader.readAsDataURL(blob);

                    closeModal();
                }, 'image/jpeg', 0.9);
            });

            cancelBtn.addEventListener('click', closeModal);
            cancelBtn2.addEventListener('click', closeModal);
            modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
        });
    </script>
</x-app-layout>
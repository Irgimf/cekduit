<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kebijakan Privasi — CekDuit</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet"/>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Figtree', sans-serif; background: #F0F4F8; color: #1E293B; }
        .container { max-width: 720px; margin: 0 auto; padding: 40px 24px; }
        .card { background: #fff; border-radius: 16px; padding: 40px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .back { display: inline-flex; align-items: center; gap: 6px; color: #014BAA; font-size: 14px; font-weight: 600; text-decoration: none; margin-bottom: 24px; }
        .logo { display: flex; align-items: center; gap: 10px; margin-bottom: 28px; }
        .logo-icon { width: 40px; height: 40px; background: #014BAA; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
        .logo-text { font-size: 20px; font-weight: 800; color: #014BAA; }
        h1 { font-size: 24px; font-weight: 800; color: #0F172A; margin-bottom: 6px; }
        .meta { font-size: 13px; color: #94A3B8; margin-bottom: 28px; padding-bottom: 20px; border-bottom: 1px solid #F1F5F9; }
        h2 { font-size: 17px; font-weight: 700; color: #0F172A; margin: 24px 0 10px; }
        p { font-size: 14px; color: #64748B; line-height: 1.8; margin-bottom: 12px; }
        ul { padding-left: 20px; margin-bottom: 12px; }
        ul li { font-size: 14px; color: #64748B; line-height: 1.8; margin-bottom: 4px; }
    </style>
</head>
<body>
<div class="container">
    <a href="{{ url()->previous() }}" class="back">← Kembali</a>
    <div class="card">
       <div class="logo">
            <x-logo-icon size="40" radius="10" />
            <span class="logo-text">CekDuit</span>
        </div>

        <h1>Kebijakan Privasi</h1>
        <div class="meta">Terakhir diperbarui: {{ date('d F Y') }}</div>

        <p>CekDuit berkomitmen untuk melindungi privasi penggunanya. Kebijakan ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi kamu.</p>

        <h2>1. Informasi yang Kami Kumpulkan</h2>
        <p>Kami mengumpulkan informasi berikut:</p>
        <ul>
            <li><strong>Data Akun:</strong> Nama, alamat email, dan foto profil</li>
            <li><strong>Data Keuangan:</strong> Catatan transaksi, saldo rekening, kategori yang kamu buat</li>
            <li><strong>Data Penggunaan:</strong> Log akses dan aktivitas di dalam aplikasi</li>
        </ul>

        <h2>2. Bagaimana Kami Menggunakan Informasi</h2>
        <p>Informasi yang dikumpulkan digunakan untuk:</p>
        <ul>
            <li>Menyediakan dan meningkatkan layanan CekDuit</li>
            <li>Memproses pembayaran subscription</li>
            <li>Mengirimkan notifikasi penting terkait akun</li>
            <li>Memberikan dukungan pelanggan</li>
        </ul>

        <h2>3. Keamanan Data</h2>
        <p>Data kamu disimpan dengan aman menggunakan enkripsi standar industri. Password disimpan dalam bentuk hash dan tidak dapat dibaca oleh siapapun termasuk tim CekDuit.</p>

        <h2>4. Berbagi Data dengan Pihak Ketiga</h2>
        <p>Kami <strong>tidak menjual</strong> data pribadi kamu kepada pihak ketiga. Data keuangan kamu bersifat pribadi dan hanya dapat diakses oleh kamu sendiri.</p>

        <h2>5. Retensi Data</h2>
        <p>Data akun disimpan selama akun masih aktif. Jika kamu menghapus akun, semua data akan dihapus permanen dalam waktu 30 hari.</p>

        <h2>6. Hak Pengguna</h2>
        <p>Kamu berhak untuk:</p>
        <ul>
            <li>Mengakses data pribadi kamu</li>
            <li>Meminta koreksi data yang tidak akurat</li>
            <li>Menghapus akun dan semua data terkait</li>
            <li>Mengekspor data keuangan kamu</li>
        </ul>

        <h2>7. Cookie</h2>
        <p>Kami menggunakan cookie untuk menjaga sesi login dan meningkatkan pengalaman penggunaan. Kamu dapat menonaktifkan cookie di browser, namun beberapa fitur mungkin tidak berfungsi optimal.</p>

        <h2>8. Perubahan Kebijakan</h2>
        <p>Kebijakan privasi ini dapat diperbarui sewaktu-waktu. Perubahan signifikan akan diberitahukan melalui email.</p>

        <h2>9. Kontak</h2>
        <p>Untuk pertanyaan terkait privasi, hubungi kami melalui <a href="{{ route('legal.contact') }}" style="color:#014BAA;">halaman kontak</a>.</p>
    </div>
</div>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Syarat & Ketentuan — CekDuit</title>
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
    <a href="{{ url()->previous() }}" class="back">
        ← Kembali
    </a>
    <div class="card">
       <div class="logo">
            <x-logo-icon size="40" radius="10" />
            <span class="logo-text">CekDuit</span>
        </div>

        <h1>Syarat & Ketentuan</h1>
        <div class="meta">Terakhir diperbarui: {{ date('d F Y') }}</div>

        <p>Dengan mendaftar dan menggunakan layanan CekDuit, kamu menyetujui syarat dan ketentuan berikut ini. Harap baca dengan seksama sebelum menggunakan layanan kami.</p>

        <h2>1. Penerimaan Syarat</h2>
        <p>Dengan membuat akun dan mengakses CekDuit, kamu menyatakan bahwa kamu berusia minimal 13 tahun dan menyetujui untuk terikat oleh Syarat & Ketentuan ini.</p>

        <h2>2. Deskripsi Layanan</h2>
        <p>CekDuit adalah aplikasi manajemen keuangan pribadi yang memungkinkan pengguna untuk:</p>
        <ul>
            <li>Mencatat pemasukan dan pengeluaran</li>
            <li>Mengelola rekening (bank, e-wallet, dompet)</li>
            <li>Membuat laporan keuangan</li>
            <li>Mengatur budget dan target tabungan (fitur Premium)</li>
        </ul>

        <h2>3. Akun Pengguna</h2>
        <p>Kamu bertanggung jawab untuk menjaga kerahasiaan password akun. Segala aktivitas yang terjadi di bawah akunmu adalah tanggung jawabmu. Harap segera hubungi kami jika ada akses tidak sah ke akunmu.</p>

        <h2>4. Paket Berlangganan</h2>
        <p>CekDuit menawarkan paket Gratis dan Premium. Paket Premium dikenakan biaya Rp 15.000/bulan atau Rp 120.000/tahun. Pembayaran dilakukan melalui konfirmasi manual via WhatsApp. Tidak ada refund untuk pembayaran yang sudah dikonfirmasi.</p>

        <h2>5. Penggunaan yang Dilarang</h2>
        <p>Kamu dilarang untuk:</p>
        <ul>
            <li>Menggunakan layanan untuk tujuan ilegal</li>
            <li>Mencoba mengakses sistem tanpa izin</li>
            <li>Menyebarkan informasi palsu atau menyesatkan</li>
            <li>Melakukan aktivitas spam atau penyalahgunaan sistem</li>
        </ul>

        <h2>6. Ketersediaan Layanan</h2>
        <p>Kami berusaha menjaga layanan tetap tersedia 24/7, namun tidak menjamin ketersediaan tanpa gangguan. Pemeliharaan berkala mungkin menyebabkan gangguan sementara.</p>

        <h2>7. Penghentian Layanan</h2>
        <p>Kami berhak menangguhkan atau menghapus akun yang melanggar Syarat & Ketentuan ini tanpa pemberitahuan sebelumnya.</p>

        <h2>8. Perubahan Syarat</h2>
        <p>Kami dapat memperbarui Syarat & Ketentuan ini sewaktu-waktu. Perubahan akan diberitahukan melalui email atau notifikasi di aplikasi. Penggunaan berkelanjutan setelah perubahan berarti kamu menyetujui syarat yang baru.</p>

        <h2>9. Hukum yang Berlaku</h2>
        <p>Syarat & Ketentuan ini diatur oleh hukum yang berlaku di Indonesia. Segala sengketa akan diselesaikan melalui musyawarah mufakat.</p>

        <h2>10. Hubungi Kami</h2>
        <p>Jika ada pertanyaan terkait Syarat & Ketentuan ini, hubungi kami melalui <a href="{{ route('legal.contact') }}" style="color:#014BAA;">halaman kontak</a> kami.</p>
    </div>
</div>
</body>
</html>

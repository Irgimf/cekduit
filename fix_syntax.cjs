const fs = require('fs');

function fixMobileAccountForm() {
    let f = 'resources/views/mobile/account-form.blade.php';
    let content = fs.readFileSync(f, 'utf8');
    content = content.replace(
        /@foreach \(\[\s*\['value' => 'cash', 'label' => 'Cash', 'emoji' => '<x-heroicon-o-wallet class="w-6 h-6 inline text-purple-500" \/>'\],\s*\['value' => 'bank', 'label' => 'Bank', 'emoji' => '<x-heroicon-o-building-library class="w-6 h-6 inline text-blue-500" \/>'\],\s*\['value' => 'e_wallet', 'label' => 'E-Wallet', 'emoji' => '<x-heroicon-o-device-phone-mobile class="w-6 h-6 inline text-gray-500" \/>'\],\s*\] as \$type\)/,
        `@php
                            $types = [
                                ['value' => 'cash', 'label' => 'Cash', 'icon' => 'heroicon-o-wallet', 'color' => 'text-purple-500'],
                                ['value' => 'bank', 'label' => 'Bank', 'icon' => 'heroicon-o-building-library', 'color' => 'text-blue-500'],
                                ['value' => 'e_wallet', 'label' => 'E-Wallet', 'icon' => 'heroicon-o-device-phone-mobile', 'color' => 'text-gray-500'],
                            ];
                        @endphp
                        @foreach ($types as $type)`
    );
    content = content.replace(/\{\{ \$type\['emoji'\] \}\}/, `<x-dynamic-component :component="$type['icon']" class="w-6 h-6 inline {{ $type['color'] }}" />`);
    fs.writeFileSync(f, content);
}

function fixOnboardingAccount() {
    let f = 'resources/views/onboarding/account.blade.php';
    let content = fs.readFileSync(f, 'utf8');
    content = content.replace(
        /@foreach \(\[\s*\['cash',     '<x-heroicon-o-wallet class="w-6 h-6 inline text-purple-500" \/>', 'Dompet \/ Cash'\],\s*\['bank',     '<x-heroicon-o-building-library class="w-6 h-6 inline text-blue-500" \/>', 'Bank'\],\s*\['e_wallet', '<x-heroicon-o-device-phone-mobile class="w-6 h-6 inline text-gray-500" \/>', 'E-Wallet'\],\s*\] as \[\$val, \$emoji, \$label\]\)/,
        `@php
                        $types = [
                            ['cash', 'heroicon-o-wallet', 'text-purple-500', 'Dompet / Cash'],
                            ['bank', 'heroicon-o-building-library', 'text-blue-500', 'Bank'],
                            ['e_wallet', 'heroicon-o-device-phone-mobile', 'text-gray-500', 'E-Wallet'],
                        ];
                    @endphp
                    @foreach ($types as [$val, $icon, $color, $label])`
    );
    content = content.replace(/\{!! \$emoji !!\}/g, `<x-dynamic-component :component="$icon" class="w-6 h-6 inline {{ $color }}" />`);
    content = content.replace(/\{\{ \$emoji \}\}/g, `<x-dynamic-component :component="$icon" class="w-6 h-6 inline {{ $color }}" />`);
    fs.writeFileSync(f, content);
}

function fixPaymentPending() {
    let f = 'resources/views/mobile/payment-pending.blade.php';
    let content = fs.readFileSync(f, 'utf8');
    content = content.replace(
        /@foreach \(\[\s*\['1', '#014BAA', 'Tunggu balasan WhatsApp dari admin CekDuit'\],\s*\['2', '#014BAA', 'Lakukan pembayaran sesuai instruksi yang dikirim admin'\],\s*\['3', '#014BAA', 'Kirim bukti transfer ke WhatsApp admin'\],\s*\['<x-heroicon-o-check class="w-5 h-5 inline text-green-500" \/>', '#22C55E', 'Akun Premium kamu akan aktif dalam hitungan menit'\],\s*\] as \[\$num, \$bg, \$text\]\)/,
        `@php
                    $steps = [
                        ['1', '#014BAA', 'Tunggu balasan WhatsApp dari admin CekDuit'],
                        ['2', '#014BAA', 'Lakukan pembayaran sesuai instruksi yang dikirim admin'],
                        ['3', '#014BAA', 'Kirim bukti transfer ke WhatsApp admin'],
                        ['check', '#22C55E', 'Akun Premium kamu akan aktif dalam hitungan menit'],
                    ];
                @endphp
                @foreach ($steps as [$num, $bg, $text])`
    );
    content = content.replace(
        /\{\{ \$num \}\}/,
        `@if($num === 'check') <x-heroicon-o-check class="w-5 h-5 inline text-green-500" /> @else {{ $num }} @endif`
    );
    // There might be {!! $num !!} instead
    content = content.replace(
        /\{!! \$num !!\}/,
        `@if($num === 'check') <x-heroicon-o-check class="w-5 h-5 inline text-green-500" /> @else {{ $num }} @endif`
    );
    fs.writeFileSync(f, content);
}

function fixOnboardingIndex() {
    let f = 'resources/views/onboarding/index.blade.php';
    let content = fs.readFileSync(f, 'utf8');
    content = content.replace(
        /@foreach \(\[\s*\['<x-heroicon-o-building-library class="w-6 h-6 inline text-blue-500" \/>', '#E8F0FB', '#014BAA', 'Langkah 1', 'Tambah rekening pertamamu', 'Dompet, bank, atau e-wallet'\],\s*\['<x-heroicon-o-tag class="w-5 h-5 inline text-blue-500" \/>\?', '#DCFCE7', '#16a34a', 'Langkah 2', 'Pilih kategori', 'Pengeluaran dan pemasukan'\],\s*\['<x-heroicon-o-currency-dollar class="w-6 h-6 inline text-green-500" \/>', '#FEF9C3', '#ca8a04', 'Langkah 3', 'Catat transaksi pertama', 'Opsional, bisa dilewati'\],\s*\] as \[\$emoji, \$bg, \$color, \$step, \$title, \$desc\]\)/,
        `@php
                $steps = [
                    ['heroicon-o-building-library', 'text-blue-500', '#E8F0FB', '#014BAA', 'Langkah 1', 'Tambah rekening pertamamu', 'Dompet, bank, atau e-wallet'],
                    ['heroicon-o-tag', 'text-blue-500', '#DCFCE7', '#16a34a', 'Langkah 2', 'Pilih kategori', 'Pengeluaran dan pemasukan'],
                    ['heroicon-o-currency-dollar', 'text-green-500', '#FEF9C3', '#ca8a04', 'Langkah 3', 'Catat transaksi pertama', 'Opsional, bisa dilewati'],
                ];
            @endphp
            @foreach ($steps as [$icon, $iconColor, $bg, $color, $step, $title, $desc])`
    );
    content = content.replace(
        /\{!! \$emoji !!\}/g,
        `<x-dynamic-component :component="$icon" class="w-6 h-6 inline {{ $iconColor }}" />`
    );
    content = content.replace(
        /\{\{ \$emoji \}\}/g,
        `<x-dynamic-component :component="$icon" class="w-6 h-6 inline {{ $iconColor }}" />`
    );
    fs.writeFileSync(f, content);
}

fixMobileAccountForm();
fixOnboardingAccount();
fixPaymentPending();
fixOnboardingIndex();
console.log('Fixed syntax errors.');

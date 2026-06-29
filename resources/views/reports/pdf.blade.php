<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h2 { margin-bottom: 4px; }
        .summary { margin-bottom: 16px; }
        .summary td { padding: 4px 12px; }
        table.data { width: 100%; border-collapse: collapse; }
        table.data th, table.data td { border: 1px solid #ddd; padding: 6px 8px; text-align: left; }
        table.data th { background: #f3f4f6; }
        .income { color: #16a34a; }
        .expense { color: #dc2626; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h2>Laporan Keuangan CekDuit</h2>
    <p>Periode: {{ $periodLabel }}</p>

    <table class="summary">
        <tr>
            <td><strong>Total Pemasukan</strong></td>
            <td>Rp {{ number_format($summary['total_income'], 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Total Pengeluaran</strong></td>
            <td>Rp {{ number_format($summary['total_expense'], 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Selisih (Net)</strong></td>
            <td>Rp {{ number_format($summary['net'], 0, ',', '.') }}</td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Kategori</th>
                <th>Rekening</th>
                <th>Deskripsi</th>
                <th class="text-right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                    <td>{{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}</td>
                    <td>{{ $transaction->category->name }}</td>
                    <td>{{ $transaction->account->name }}</td>
                    <td>{{ $transaction->description ?: '-' }}</td>
                    <td class="text-right {{ $transaction->type === 'income' ? 'income' : 'expense' }}">
                        {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;">Tidak ada transaksi pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
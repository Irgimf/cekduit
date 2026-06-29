<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(protected Collection $transactions, protected array $summary)
    {
    }

    public function collection(): Collection
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return ['Tanggal', 'Jenis', 'Kategori', 'Rekening', 'Deskripsi', 'Jumlah'];
    }

    public function map($transaction): array
    {
        return [
            $transaction->transaction_date->format('d/m/Y'),
            $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran',
            $transaction->category->name,
            $transaction->account->name,
            $transaction->description ?: '-',
            $transaction->type === 'income' ? $transaction->amount : -$transaction->amount,
        ];
    }
}
<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeductAdminFees extends Command
{
    protected $signature   = 'cekduit:deduct-admin-fees';
    protected $description = 'Potong biaya admin rekening bank setiap tanggal 1';

    public function handle(): void
    {
        $accounts = Account::where('type', 'bank')
            ->where('admin_fee', '>', 0)
            ->with('user')
            ->get();

        $count = 0;

        foreach ($accounts as $account) {
            if ($account->balance < $account->admin_fee) {
                // Skip kalau saldo tidak cukup, opsional: bisa log warning
                $this->warn("Saldo tidak cukup untuk admin fee: {$account->name} (user: {$account->user->email})");
                continue;
            }

            DB::transaction(function () use ($account) {
                // Cari atau buat kategori "Biaya Admin"
                $category = $account->user->categories()->firstOrCreate(
                    ['name' => 'Biaya Admin', 'type' => 'expense'],
                    ['name' => 'Biaya Admin', 'type' => 'expense']
                );

                // Catat sebagai transaksi pengeluaran
                $account->user->transactions()->create([
                    'account_id'       => $account->id,
                    'category_id'      => $category->id,
                    'type'             => 'expense',
                    'is_transfer'      => false,
                    'amount'           => $account->admin_fee,
                    'description'      => 'Biaya admin ' . $account->name,
                    'transaction_date' => now()->toDateString(),
                ]);

                // Potong saldo
                $account->decrement('balance', $account->admin_fee);
            });

            $count++;
        }

        $this->info("Admin fee berhasil dipotong untuk {$count} rekening.");
    }
}
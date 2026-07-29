<?php

namespace App\Console\Commands;

use App\Models\RecurringTransaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ProcessRecurringTransactions extends Command
{
    protected $signature   = 'cekduit:process-recurring';
    protected $description = 'Proses transaksi berulang yang jatuh tempo hari ini';

    public function handle(): void
    {
        $today = now()->toDateString();

        $dueTodayItems = RecurringTransaction::where('is_active', true)
            ->where('next_run_at', '<=', $today)
            ->whereNull('end_date')
            ->orWhere(function ($q) use ($today) {
                $q->where('is_active', true)
                  ->where('next_run_at', '<=', $today)
                  ->where('end_date', '>=', $today);
            })
            ->with(['user', 'account', 'category'])
            ->get();

        $count = 0;

        foreach ($dueTodayItems as $item) {
            if ($item->isExpired()) {
                $item->update(['is_active' => false]);
                continue;
            }

            DB::transaction(function () use ($item, $today, &$count) {
                // Buat transaksi
                $transaction = $item->user->transactions()->create([
                    'account_id'       => $item->account_id,
                    'category_id'      => $item->category_id,
                    'type'             => $item->type,
                    'amount'           => $item->amount,
                    'description'      => $item->description ?? $item->frequencyLabel(),
                    'transaction_date' => $today,
                    'is_transfer'      => false,
                ]);

                // Update saldo rekening
                if ($item->type === 'income') {
                    $item->account->increment('balance', $item->amount);
                } else {
                    $item->account->decrement('balance', $item->amount);
                }

                // Update kapan terakhir & selanjutnya dijalankan
                $nextRun = $item->calculateNextRun(now());
                $item->update([
                    'last_run_at' => $today,
                    'next_run_at' => $nextRun->toDateString(),
                ]);

                $count++;
            });
        }

        $this->info("Berhasil memproses {$count} transaksi berulang.");
    }
}
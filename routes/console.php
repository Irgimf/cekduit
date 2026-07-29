<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Recurring transactions — jalankan setiap hari jam 00:05
Schedule::command('cekduit:process-recurring')->dailyAt('00:05');

// Admin fee — jalankan setiap tanggal 1
Schedule::command('cekduit:deduct-admin-fees')->monthlyOn(1, '00:05');
    
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

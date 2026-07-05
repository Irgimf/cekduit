<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('cekduit:deduct-admin-fees')
    ->monthlyOn(1, '00:05'); // Setiap tanggal 1, jam 00:05
    
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

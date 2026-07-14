<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Command baru: php artisan email:reminder-cuti (lihat app/Console/Commands/SendLeaveReminderEmail.php)
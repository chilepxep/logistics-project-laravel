<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Hẹn giờ chạy tự động lệnh dọn dẹp vào lúc 2:00 sáng mỗi ngày
Schedule::command('notifications:cleanup')->dailyAt('02:00');
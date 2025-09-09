<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule HaynesPro cache cleanup to run daily at 2 AM
Schedule::command('haynes-pro:purge-expired')->dailyAt('02:00');

<?php

use App\Jobs\SendProductToScraper;
use App\Models\MonitoredProduct;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('app:send-job-to-scraper-command')->everyThirtyMinutes();
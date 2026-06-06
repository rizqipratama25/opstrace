<?php

use App\Jobs\SendProductToScraper;
use App\Models\MonitoredProduct;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $products = MonitoredProduct::all();

        foreach ($products as $product) {

        SendProductToScraper::dispatch([
            'id' => $product->id,
            'name' => $product->name,
            'url' => $product->url,
        ]);
    }
})->everyMinute();

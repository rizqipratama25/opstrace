<?php

namespace App\Console\Commands;

use App\Jobs\SendProductToScraper;
use App\Models\MonitoredProduct;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:send-job-to-scraper-command')]
#[Description('Scrape monitored products every thirty minutes')]
class SendJobToScraperCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        MonitoredProduct::chunk(100, function($products) {
            foreach ($products as $product) {
                SendProductToScraper::dispatch($product);
            }
        });
    }
}

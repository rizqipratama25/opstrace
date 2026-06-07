<?php

namespace App\Console\Commands;

use App\Models\MonitoredProduct;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:send-job-to-scraper')]
#[Description('Command description')]
class SendJobToScraper extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        MonitoredProduct::chunk(100, function($products) {

        });
    }
}

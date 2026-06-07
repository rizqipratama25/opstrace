<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Redis;

class SendProductToScraper implements ShouldQueue
{
    use Queueable;

    public array $product;

    /**
     * Create a new job instance.
     */
    public function __construct(array $product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Redis::rPush(
            'scraper_queue',
            json_encode([
                "id" => $this->product['id'],
                "name" => $this->product['name'],
                "product_url" => $this->product['product_url'],
            ])
        );
    }
}

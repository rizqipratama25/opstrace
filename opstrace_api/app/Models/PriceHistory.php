<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'monitored_product_id',
    'price', 
    'detected_at', 
])]
class PriceHistory extends Model
{
    protected function casts(): array
    {
        return [
            "detected_at" => "datetime",
        ];
    }

    public function monitoredProduct(): BelongsTo
    {
        return $this->belongsTo(MonitoredProduct::class);
    }
}

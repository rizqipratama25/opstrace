<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'monitored_product_id',
    'type', 
    'previous_price',
    'current_price',
    'message',
    'is_sent'
])]
class Alert extends Model
{
    protected function casts(): array
    {
        return [
            "is_sent" => "boolean",
        ];
    }

    public function monitoredProduct(): BelongsTo
    {
        return $this->belongsTo(MonitoredProduct::class);
    }
}

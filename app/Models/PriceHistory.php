<?php

namespace App\Models;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PriceHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'price',
        'high_price',
        'low_price',
        'fetched_at'
    ];

    protected function casts(): array
    {
        return [
            'price'         => 'decimal:4',
            'high_price'    => 'decimal:4',
            'low_price'     => 'decimal:4',
            'fetched_at'    => 'datetime'
        ];
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }
}

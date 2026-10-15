<?php

namespace App\Models;

use App\Models\PriceAlert;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'type',
        'symbol',
        'current_price',
        'high_price',
        'low_price',
        'variation_24h',
    ];

    protected function casts(): array
    {
        return [
            'current_price' => 'decimal:4',
            'high_price'    => 'decimal:4',
            'low_price'     => 'decimal:4',
            'variation_24h' => 'decimal:2',
        ];
    }

    public function priceHistories(): HasMany
    {
        return $this->hasMany(PriceHistory::class);
    }

    public function alerts(): HasMany
    {
        return $this->hasMany(PriceAlert::class);
    }
}

<?php

namespace App\Models;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PriceAlert extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'asset_id',
        'target_price',
        'condition',
        'is_triggered',
        'triggered_at'
    ];

    protected function casts(): array
    {
        return [
            'target_price' => 'decimal:4',
            'is_triggered' => 'boolean',
            'triggered_at' => 'datetime',
        ];
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

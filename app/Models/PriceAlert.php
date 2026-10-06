<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceAlert extends Model
{
    protected $fillable = [
        'user_id',
        'asset_id',
        'target_price',
        'condition',
        'is_triggered',
        'triggered_at',
 ];

 protected function casts(): array
 {
 return [
 'target_price' => 'decimal:4',
 'is_triggered' => 'boolean',
 'triggered_at' => 'datetime',
 ];

 }
 public function user()
 {
 return $this->belongsTo(User::class);
 }
 
 public function asset()
 {
 return $this->belongsTo(Asset::class);
 }
}

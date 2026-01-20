<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'user_id',
        'status',
    ];
    // Casts for convenience
    protected $casts = [
        'status' => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
     /**
     * Optional helper: total order amount
     */
    public function getTotalAmountAttribute(): float
    {
        return $this->items->sum(fn($item) => $item->price * $item->quantity);
    }


}

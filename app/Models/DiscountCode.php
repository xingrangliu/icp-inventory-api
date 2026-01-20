<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class DiscountCode extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'code',
        'percentage',
        'active',
        'expires_at',
    ];
    // Casts for convenience
    protected $casts = [
        'percentage' => 'float',
        'active' => 'boolean',
        'expires_at' => 'datetime',
    ];
     /**
     * Scope to get only active discount codes
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true)
                     ->where(function($q){
                         $q->whereNull('expires_at')
                           ->orWhere('expires_at', '>', Carbon::now());
                     });
    }
        /**
     * Check if a discount code is valid
     */
    public function isValid(): bool
    {
        return $this->active && (is_null($this->expires_at) || $this->expires_at->isFuture());
    }
     /**
     * Apply discount to a given amount
     */
    public function apply(float $amount): float
    {
        return round($amount * (1 - $this->percentage / 100), 2);
    }




}

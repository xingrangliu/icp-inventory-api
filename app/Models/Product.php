<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'name',
        'sku',
        'price',
        'stock_quantity',
        'category',
    ];
    // Optional: Cast price to float and stock_quantity to integer
    protected $casts = [
        'price' => 'float',
        'stock_quantity' => 'integer',
    ];

     // Relationships
    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class)
                    ->using(Product_warehouse::class)
                    ->withPivot('stock_quantity')
                    ->withTimestamps();
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }


}

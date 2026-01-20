<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Testing\Fluent\Concerns\Has;

class Product_warehouse extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'stock_quantity',
    ];
    // Cast stock_quantity as integer
    protected $casts = [
        'stock_quantity' => 'integer',
    ];
     /**
     * Optional: Helper method to adjust stock
     */
    public function adjustStock(int $amount): void
    {
        $this->stock_quantity += $amount;
        $this->save();
    }

}

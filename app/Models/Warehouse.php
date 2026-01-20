<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Warehouse extends Model
{
    //
    use HasFactory;
    protected $fillable = ['name', 'location'];

    public function products()
    {
        return $this->belongsToMany(Product::class)
                    ->using(Product_warehouse::class)
                    ->withPivot('stock_quantity')
                    ->withTimestamps();
    }
}

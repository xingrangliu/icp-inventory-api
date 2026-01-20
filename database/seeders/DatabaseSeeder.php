<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\OrderItem;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        User::factory(10)->create();

        // Warehouses
        $warehouses = Warehouse::factory(3)->create();

        // Products
        foreach ($warehouses as $warehouse) {
            Product::factory(10)->create([
                'warehouse_id' => $warehouse->id,
            ]);
        }

        // Discount codes
        DiscountCode::factory(5)->create();

        // Orders + Items
        Order::factory(20)->create()->each(function ($order) {
            $products = Product::inRandomOrder()->take(rand(1, 3))->get();

            foreach ($products as $product) {
                OrderItem::factory()->create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'price' => $product->price,
                ]);
            }
        });
    }
}

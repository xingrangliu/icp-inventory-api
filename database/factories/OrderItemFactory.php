<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\Product;
use App\Models\DiscountCode;
;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get a random product from the database
        $product = Product::inRandomOrder()->first();

        // Get a random discount code or null
        $discount = DiscountCode::inRandomOrder()->first();

        return [
            //
            'order_id' => Order::factory(),
            'product_id' => $product->id,
            'discount_code_id' => DiscountCode::inRandomOrder()->first()?->id,
            'quantity' => $this->faker->numberBetween(1, 5),
            'price' => $product->price,
        ];
    }
}

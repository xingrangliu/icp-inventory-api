<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DiscountCode>
 */
class DiscountCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'code' => strtoupper($this->faker->bothify('DISC###')),
            'percentage' => $this->faker->numberBetween(5, 50), // 5%–50%
            'active' => $this->faker->boolean(80), // 80% active
            'expires_at' => $this->faker->optional()->dateTimeBetween('now', '+6 months'),
        ];
    }
}

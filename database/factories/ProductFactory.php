<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_name' => fake()->sentence(),
            'thumbs' => 'https://m.media-amazon.com/images/I/81aot0jAfFL._AC_SX679_.jpg;https://images-na.ssl-images-amazon.com/images/I/71pC69I3lzL.__AC_SX300_SY300_QL70_FMwebp_.jpg;https://m.media-amazon.com/images/I/718Pz9bYxWL._AC_SX679_.jpg',
            'price' => fake()->randomFloat(2, 600, 2400),
        ];
    }
}

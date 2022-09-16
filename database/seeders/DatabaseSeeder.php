<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\Product::factory()->create([
            'product_name' => 'Apple MacBook Pro (16 pulgadas, 16 GB de RAM, almacenamiento de 1 TB, 2,3 GHz Intel Core i9)',
            'price' => 1379,
            'thumbs' => 'https://m.media-amazon.com/images/I/81aot0jAfFL._AC_SX679_.jpg;https://images-na.ssl-images-amazon.com/images/I/71pC69I3lzL.__AC_SX300_SY300_QL70_FMwebp_.jpg;https://m.media-amazon.com/images/I/718Pz9bYxWL._AC_SX679_.jpg',
        ]);

        \App\Models\Product::factory(10)->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\Products;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'), // password
        ]);
        Products::factory(40)->create([
            'name' => 'Test Product',
            'description' => 'This is a test product',
            'price' => 19.99,
            'quantity' => 10,
            'category' => 'Test Category',
            'imagepath' => 'https://example.com/test-product.jpg'
        ]);
    }
}

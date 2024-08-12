<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Rizky Arroyana F',
            'email' => 'arroy@test.com',
            'password' => Hash::make('123456'),
        ]);

        // Category Factory
        Category::factory(2)->create();

        // Product Factory
        Product::factory(100)->create();
    }
}

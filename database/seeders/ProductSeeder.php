<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $electronics = Category::where('name', 'Electronics')->first();
        $clothing = Category::where('name', 'Clothing')->first();
        $books = Category::where('name', 'Books')->first();
        $home = Category::where('name', 'Home & Garden')->first();
        $sports = Category::where('name', 'Sports')->first();

        $products = [
            ['name' => 'Smartphone Pro', 'description' => 'Latest smartphone with advanced features', 'price' => 999.99, 'category_id' => $electronics->id],
            ['name' => 'Wireless Earbuds', 'description' => 'High-quality wireless earbuds with noise cancellation', 'price' => 149.99, 'category_id' => $electronics->id],
            ['name' => 'Laptop UltraBook', 'description' => 'Lightweight laptop for professionals', 'price' => 1299.99, 'category_id' => $electronics->id],
            ['name' => 'Smart Watch', 'description' => 'Fitness tracking smartwatch', 'price' => 299.99, 'category_id' => $electronics->id],
            ['name' => 'Tablet Mini', 'description' => 'Compact tablet for entertainment', 'price' => 449.99, 'category_id' => $electronics->id],
            ['name' => 'Cotton T-Shirt', 'description' => 'Comfortable cotton t-shirt', 'price' => 19.99, 'category_id' => $clothing->id],
            ['name' => 'Denim Jeans', 'description' => 'Classic denim jeans', 'price' => 49.99, 'category_id' => $clothing->id],
            ['name' => 'Winter Jacket', 'description' => 'Warm winter jacket', 'price' => 129.99, 'category_id' => $clothing->id],
            ['name' => 'Running Shoes', 'description' => 'Professional running shoes', 'price' => 89.99, 'category_id' => $clothing->id],
            ['name' => 'Baseball Cap', 'description' => 'Stylish baseball cap', 'price' => 14.99, 'category_id' => $clothing->id],
            ['name' => 'JavaScript Guide', 'description' => 'Complete guide to JavaScript programming', 'price' => 39.99, 'category_id' => $books->id],
            ['name' => 'Laravel Cookbook', 'description' => 'Laravel development cookbook', 'price' => 44.99, 'category_id' => $books->id],
            ['name' => 'Vue.js Essentials', 'description' => 'Essential Vue.js for developers', 'price' => 34.99, 'category_id' => $books->id],
            ['name' => 'Python Basics', 'description' => 'Learning Python from scratch', 'price' => 29.99, 'category_id' => $books->id],
            ['name' => 'Design Patterns', 'description' => 'Software design patterns book', 'price' => 49.99, 'category_id' => $books->id],
            ['name' => 'Garden Tools Set', 'description' => 'Complete garden tools set', 'price' => 79.99, 'category_id' => $home->id],
            ['name' => 'LED Lamp', 'description' => 'Energy efficient LED lamp', 'price' => 24.99, 'category_id' => $home->id],
            ['name' => 'Coffee Maker', 'description' => 'Automatic coffee maker', 'price' => 59.99, 'category_id' => $home->id],
            ['name' => 'Plant Pot Set', 'description' => 'Decorative plant pots', 'price' => 19.99, 'category_id' => $home->id],
            ['name' => 'Wall Clock', 'description' => 'Modern wall clock', 'price' => 29.99, 'category_id' => $home->id],
            ['name' => 'Basketball', 'description' => 'Professional basketball', 'price' => 29.99, 'category_id' => $sports->id],
            ['name' => 'Tennis Racket', 'description' => 'Professional tennis racket', 'price' => 89.99, 'category_id' => $sports->id],
            ['name' => 'Yoga Mat', 'description' => 'Premium yoga mat', 'price' => 34.99, 'category_id' => $sports->id],
            ['name' => 'Dumbbells Set', 'description' => 'Adjustable dumbbells set', 'price' => 149.99, 'category_id' => $sports->id],
            ['name' => 'Soccer Ball', 'description' => 'Official size soccer ball', 'price' => 24.99, 'category_id' => $sports->id],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
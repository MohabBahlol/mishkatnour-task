<?php
// database/seeders/ProductSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all categories
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->error('❌ No categories found. Please run CategorySeeder first!');
            return;
        }

        $products = [
            // Electronics
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'Latest Apple smartphone with advanced camera features',
                'price' => 1099.99,
                'category_id' => $categories->where('name', 'Electronics')->first()->id,
                'status' => 'active',
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'description' => 'Premium Android smartphone with AI features',
                'price' => 899.99,
                'category_id' => $categories->where('name', 'Electronics')->first()->id,
                'status' => 'active',
            ],
            [
                'name' => 'Sony WH-1000XM5',
                'description' => 'Noise-cancelling wireless headphones',
                'price' => 349.99,
                'category_id' => $categories->where('name', 'Electronics')->first()->id,
                'status' => 'active',
            ],
            [
                'name' => 'MacBook Pro 16"',
                'description' => 'Professional laptop for creators and developers',
                'price' => 2499.99,
                'category_id' => $categories->where('name', 'Electronics')->first()->id,
                'status' => 'active',
            ],
            [
                'name' => 'iPad Air',
                'description' => 'Versatile tablet for work and entertainment',
                'price' => 599.99,
                'category_id' => $categories->where('name', 'Electronics')->first()->id,
                'status' => 'active',
            ],

            // Clothing
            [
                'name' => 'Levi\'s 501 Original Jeans',
                'description' => 'Classic straight fit jeans',
                'price' => 89.99,
                'category_id' => $categories->where('name', 'Clothing')->first()->id,
                'status' => 'active',
            ],
            [
                'name' => 'Nike Air Max 270',
                'description' => 'Comfortable running shoes with air cushioning',
                'price' => 149.99,
                'category_id' => $categories->where('name', 'Clothing')->first()->id,
                'status' => 'active',
            ],
            [
                'name' => 'Columbia Winter Jacket',
                'description' => 'Waterproof insulated winter jacket',
                'price' => 199.99,
                'category_id' => $categories->where('name', 'Clothing')->first()->id,
                'status' => 'active',
            ],

            // Home & Kitchen
            [
                'name' => 'Instant Pot Duo 7-in-1',
                'description' => 'Electric pressure cooker with multiple functions',
                'price' => 99.99,
                'category_id' => $categories->where('name', 'Home & Kitchen')->first()->id,
                'status' => 'active',
            ],
            [
                'name' => 'Ninja Air Fryer',
                'description' => 'Digital air fryer with multiple cooking functions',
                'price' => 129.99,
                'category_id' => $categories->where('name', 'Home & Kitchen')->first()->id,
                'status' => 'active',
            ],
            [
                'name' => 'Dyson V15 Vacuum',
                'description' => 'Cordless stick vacuum with laser detection',
                'price' => 699.99,
                'category_id' => $categories->where('name', 'Home & Kitchen')->first()->id,
                'status' => 'active',
            ],

            // Books
            [
                'name' => 'Atomic Habits by James Clear',
                'description' => 'An easy & proven way to build good habits & break bad ones',
                'price' => 19.99,
                'category_id' => $categories->where('name', 'Books')->first()->id,
                'status' => 'active',
            ],
            [
                'name' => 'The Psychology of Money',
                'description' => 'Timeless lessons on wealth, greed, and happiness',
                'price' => 17.99,
                'category_id' => $categories->where('name', 'Books')->first()->id,
                'status' => 'active',
            ],

            // Sports & Outdoors
            [
                'name' => 'YETI Tundra 45 Cooler',
                'description' => 'Roto-molded cooler with bear-resistant certification',
                'price' => 299.99,
                'category_id' => $categories->where('name', 'Sports & Outdoors')->first()->id,
                'status' => 'active',
            ],
            [
                'name' => 'Coleman Sundome Tent',
                'description' => '4-person camping tent with weather protection',
                'price' => 79.99,
                'category_id' => $categories->where('name', 'Sports & Outdoors')->first()->id,
                'status' => 'active',
            ],

            // Beauty & Personal Care
            [
                'name' => 'Dyson Supersonic Hair Dryer',
                'description' => 'Professional hair dryer with intelligent heat control',
                'price' => 429.99,
                'category_id' => $categories->where('name', 'Beauty & Personal Care')->first()->id,
                'status' => 'active',
            ],
            [
                'name' => 'Philips Sonicare Toothbrush',
                'description' => 'Electric toothbrush with plaque removal technology',
                'price' => 149.99,
                'category_id' => $categories->where('name', 'Beauty & Personal Care')->first()->id,
                'status' => 'active',
            ],

            // Toys & Games
            [
                'name' => 'LEGO Millennium Falcon',
                'description' => 'Detailed Star Wars building set',
                'price' => 849.99,
                'category_id' => $categories->where('name', 'Toys & Games')->first()->id,
                'status' => 'active',
            ],
            [
                'name' => 'PlayStation 5',
                'description' => 'Next-gen gaming console',
                'price' => 499.99,
                'category_id' => $categories->where('name', 'Toys & Games')->first()->id,
                'status' => 'active',
            ],

            // Automotive
            [
                'name' => 'Michelin Pilot Sport 4S',
                'description' => 'High-performance summer tires',
                'price' => 299.99,
                'category_id' => $categories->where('name', 'Automotive')->first()->id,
                'status' => 'active',
            ],
            [
                'name' => 'Bosch Wiper Blades',
                'description' => 'Premium windshield wiper blades',
                'price' => 39.99,
                'category_id' => $categories->where('name', 'Automotive')->first()->id,
                'status' => 'active',
            ],

            // Health & Wellness
            [
                'name' => 'Fitbit Charge 6',
                'description' => 'Advanced fitness tracker with ECG app',
                'price' => 159.99,
                'category_id' => $categories->where('name', 'Health & Wellness')->first()->id,
                'status' => 'active',
            ],
            [
                'name' => 'Vitamix 5200 Blender',
                'description' => 'Professional-grade blender for smoothies',
                'price' => 449.99,
                'category_id' => $categories->where('name', 'Health & Wellness')->first()->id,
                'status' => 'active',
            ],

            // Office Supplies
            [
                'name' => 'Herman Miller Aeron Chair',
                'description' => 'Ergonomic office chair',
                'price' => 1499.99,
                'category_id' => $categories->where('name', 'Office Supplies')->first()->id,
                'status' => 'active',
            ],
            [
                'name' => 'Apple Magic Keyboard',
                'description' => 'Wireless keyboard with Touch ID',
                'price' => 149.99,
                'category_id' => $categories->where('name', 'Office Supplies')->first()->id,
                'status' => 'active',
            ],

            // Jewelry
            [
                'name' => 'Pandora Moments Bracelet',
                'description' => 'Sterling silver charm bracelet',
                'price' => 79.99,
                'category_id' => $categories->where('name', 'Jewelry')->first()->id,
                'status' => 'active',
            ],
            [
                'name' => 'Tissot PRX Watch',
                'description' => 'Swiss automatic watch with integrated bracelet',
                'price' => 699.99,
                'category_id' => $categories->where('name', 'Jewelry')->first()->id,
                'status' => 'active',
            ],

            // Furniture
            [
                'name' => 'IKEA Markus Office Chair',
                'description' => 'Ergonomic office chair with lumbar support',
                'price' => 199.99,
                'category_id' => $categories->where('name', 'Furniture')->first()->id,
                'status' => 'active',
            ],
            [
                'name' => 'West Elm Modern Sofa',
                'description' => 'Mid-century modern velvet sofa',
                'price' => 1899.99,
                'category_id' => $categories->where('name', 'Furniture')->first()->id,
                'status' => 'active',
            ],

            // Food & Beverages
            [
                'name' => 'Nespresso Vertuo Coffee Machine',
                'description' => 'Single-serve coffee and espresso machine',
                'price' => 199.99,
                'category_id' => $categories->where('name', 'Food & Beverages')->first()->id,
                'status' => 'active',
            ],
            [
                'name' => 'Breville Barista Express',
                'description' => 'Espresso machine with built-in grinder',
                'price' => 699.99,
                'category_id' => $categories->where('name', 'Food & Beverages')->first()->id,
                'status' => 'active',
            ],

            // Pet Supplies
            [
                'name' => 'Purina Pro Plan Dog Food',
                'description' => 'High-protein dry dog food for adult dogs',
                'price' => 69.99,
                'category_id' => $categories->where('name', 'Pet Supplies')->first()->id,
                'status' => 'active',
            ],
            [
                'name' => 'Furbo Dog Camera',
                'description' => 'Treat-tossing dog camera with 2-way audio',
                'price' => 199.99,
                'category_id' => $categories->where('name', 'Pet Supplies')->first()->id,
                'status' => 'active',
            ],

            // Baby Products
            [
                'name' => 'Graco 4-in-1 Car Seat',
                'description' => 'Convertible car seat for infants and toddlers',
                'price' => 299.99,
                'category_id' => $categories->where('name', 'Baby Products')->first()->id,
                'status' => 'active',
            ],
            [
                'name' => 'UPPAbaby Vista Stroller',
                'description' => 'Modular stroller system with multiple configurations',
                'price' => 999.99,
                'category_id' => $categories->where('name', 'Baby Products')->first()->id,
                'status' => 'active',
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                // 'description' => $product['description'],
                'price' => $product['price'],
                'category_id' => $product['category_id'],
                // 'status' => $product['status'],
                'created_at' => now()->subDays(rand(1, 180)),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ ' . count($products) . ' products seeded successfully!');
    }
}

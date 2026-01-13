<?php
// database/seeders/CategorySeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Electronic devices and gadgets',
                'status' => 'active',
            ],
            [
                'name' => 'Clothing',
                'description' => 'Apparel and fashion items',
                'status' => 'active',
            ],
            [
                'name' => 'Home & Kitchen',
                'description' => 'Home appliances and kitchenware',
                'status' => 'active',
            ],
            [
                'name' => 'Books',
                'description' => 'Books and educational materials',
                'status' => 'active',
            ],
            [
                'name' => 'Sports & Outdoors',
                'description' => 'Sports equipment and outdoor gear',
                'status' => 'active',
            ],
            [
                'name' => 'Beauty & Personal Care',
                'description' => 'Beauty products and personal care items',
                'status' => 'active',
            ],
            [
                'name' => 'Toys & Games',
                'description' => 'Toys and games for all ages',
                'status' => 'active',
            ],
            [
                'name' => 'Automotive',
                'description' => 'Automotive parts and accessories',
                'status' => 'active',
            ],
            [
                'name' => 'Health & Wellness',
                'description' => 'Health supplements and wellness products',
                'status' => 'active',
            ],
            [
                'name' => 'Office Supplies',
                'description' => 'Office equipment and supplies',
                'status' => 'active',
            ],
            [
                'name' => 'Jewelry',
                'description' => 'Fine jewelry and accessories',
                'status' => 'active',
            ],
            [
                'name' => 'Furniture',
                'description' => 'Home and office furniture',
                'status' => 'active',
            ],
            [
                'name' => 'Food & Beverages',
                'description' => 'Food items and beverages',
                'status' => 'active',
            ],
            [
                'name' => 'Pet Supplies',
                'description' => 'Pet food and accessories',
                'status' => 'active',
            ],
            [
                'name' => 'Baby Products',
                'description' => 'Products for babies and toddlers',
                'status' => 'active',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                // 'description' => $category['description'],
                // 'status' => $category['status'],
                'created_at' => now()->subDays(rand(1, 365)),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ ' . count($categories) . ' categories seeded successfully!');
    }
}

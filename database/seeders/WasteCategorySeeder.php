<?php

namespace Database\Seeders;

use App\Models\WasteCategory;
use Illuminate\Database\Seeder;

class WasteCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'General Waste',
                'slug' => 'general-waste',
                'description' => 'Household waste that is not separately classified.',
                'is_recyclable' => false,
                'is_compostable' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Plastic',
                'slug' => 'plastic',
                'description' => 'Plastic bottles, containers, bags and other recyclable plastics.',
                'is_recyclable' => true,
                'is_compostable' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Paper',
                'slug' => 'paper',
                'description' => 'Paper, cardboard, newspapers and related recyclable materials.',
                'is_recyclable' => true,
                'is_compostable' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Metal',
                'slug' => 'metal',
                'description' => 'Metal cans and other recyclable metal materials.',
                'is_recyclable' => true,
                'is_compostable' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Glass',
                'slug' => 'glass',
                'description' => 'Glass bottles, jars and other recyclable glass materials.',
                'is_recyclable' => true,
                'is_compostable' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Organic Waste',
                'slug' => 'organic-waste',
                'description' => 'Food scraps, leaves and other biodegradable organic materials.',
                'is_recyclable' => false,
                'is_compostable' => true,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            WasteCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
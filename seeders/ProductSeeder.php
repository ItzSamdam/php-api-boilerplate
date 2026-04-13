<?php

/*
 * Copyright © 2025 Samuel Owadayo. All rights reserved.
 */

require_once __DIR__ . '/BaseSeeder.php';
require_once __DIR__ . '/../models/Product.php';

class ProductSeeder extends BaseSeeder
{
    /**
     * Predefined categories to pick from.
     * Swap these out for real category IDs from your DB if needed.
     */
    // private array $categoryIds = [1, 2, 3, 4, 5];

    public function run(): void
    {
        $this->seedMany(function (\Faker\Generator $faker) {
            return [
                'name'        => $faker->words(nb: 3, asText: true),
                'description' => $faker->sentence(nbWords: 12),
                'price'       => $faker->randomFloat(nbMaxDecimals: 2, min: 5, max: 2000),
                // 'category_id' => $faker->randomElement($this->categoryIds),
            ];
        }, Product::class);
    }
}

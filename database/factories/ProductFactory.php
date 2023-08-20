<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=Product>
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
        $collection = [1, 2, 3, 4, 5, 6];
        shuffle($collection);

        $materials = [1, 2, 3, 4];
        shuffle($materials);

        return [
            'slug' => Str::random(10),
            'name' => fake()->name().' Product',
            'description' => fake()->sentence(),
            'product_number' => mt_rand(),
            'sku' => fake()->randomNumber(9, true),
            'quantity_in_stock' => fake()->randomNumber(2, true),
            'price' => fake()->randomFloat(2),
            'retail_price' => fake()->randomFloat(2),
            'collection_id' => $collection[0],
            'material_id' => $materials[0],
            'status' => 'Draft',
            'meta_title' => Str::limit(fake()->sentence(), 100),
            'meta_keywords' => Str::limit(fake()->sentence(), 150),
            'meta_description' => fake()->name().', '.fake()->name(),
        ];
    }
}

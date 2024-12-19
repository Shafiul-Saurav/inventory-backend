<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Str;
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
    public function definition(): array
    {
        $name = fake()->sentence;
        return [
            'category_id' => Category::latest('id')->get()->random()->id,
            'brand_id' => Brand::latest('id')->get()->random()->id,
            'supplier_id' => User::supplier()->latest()->get()->random()->id,
            'name' => $name,
            'slug' => Str::slug($name),
            'original_price' => rand(0, 999),
            'sell_price' => rand(0, 999),
            'stock' => rand(0, 99),
            'description' => fake()->paragraph(6),
            'code' => Str::uuid(),
        ];
    }
}

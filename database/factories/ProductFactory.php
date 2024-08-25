<?php

namespace Database\Factories;

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
        return [
            'name' => $name = $this->faker->name,
            'slug' => Str::slug($name),
            'summary' => $this->faker->word(),
            'description' => $this->faker->sentence(10),
            'price' => rand(500, 10000),
            'image' => $this->faker->imageUrl(),
        ];
    }
}

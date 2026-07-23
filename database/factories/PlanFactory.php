<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
{
    protected $model = \App\Models\Plan::class;

    public function definition(): array
    {
        $name = fake()->words(2, true);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 10, 200),
            'currency' => 'BRL',
            'interval' => fake()->randomElement(['month', 'year', 'lifetime']),
            'credits_included' => fake()->numberBetween(0, 100),
            'is_active' => true,
            'features' => null,
            'gateway_id' => null,
        ];
    }
}

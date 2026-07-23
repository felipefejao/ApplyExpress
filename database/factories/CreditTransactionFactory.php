<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CreditTransaction>
 */
class CreditTransactionFactory extends Factory
{
    protected $model = \App\Models\CreditTransaction::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'amount' => fake()->numberBetween(1, 100),
            'type' => fake()->randomElement(['add', 'deduct', 'refund']),
            'description' => fake()->optional()->sentence(),
            'reference_type' => null,
            'reference_id' => null,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    protected $model = \App\Models\Subscription::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'plan_id' => Plan::factory(),
            'gateway' => 'stripe',
            'gateway_subscription_id' => fake()->optional()->uuid(),
            'status' => fake()->randomElement(['active', 'canceled', 'trialing', 'past_due']),
            'trial_ends_at' => fake()->optional()->dateTimeBetween('+1 day', '+14 days'),
            'starts_at' => now(),
            'ends_at' => fake()->optional()->dateTimeBetween('+1 month', '+1 year'),
            'canceled_at' => null,
        ];
    }
}

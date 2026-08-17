<?php

namespace Database\Factories;

use App\Models\Curriculo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Curriculo>
 */
class CurriculoFactory extends Factory
{
    protected $model = Curriculo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'description' => $this->faker->sentence(),
            'external_url' => $this->faker->url(),
            'language' => $this->faker->randomElement(['pt_br', 'us', 'es', 'fr', 'de']),
        ];
    }
}

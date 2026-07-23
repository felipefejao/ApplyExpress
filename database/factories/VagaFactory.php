<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vaga>
 */
class VagaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'empresa' => $this->faker->company(),
            'email' => $this->faker->companyEmail(),
            'recrutador' => $this->faker->optional()->name(),
            'cargo' => $this->faker->jobTitle(),
            'enviado' => $this->faker->boolean(),
            'language' => $this->faker->randomElement(['pt_br', 'us', 'es', 'de', 'fr']),
            'relocation' => $this->faker->boolean(),
            'relocation_city' => $this->faker->optional()->city(),
            'is_public' => $this->faker->boolean(),
        ];
    }
}

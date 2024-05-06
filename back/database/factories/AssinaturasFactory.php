<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assinaturas>
 */
class AssinaturasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'descricao' => $this->faker->word,
            'valor' => $this->faker->randomFloat(2, 0, 999),
            'dia_vencimento' => $this->faker->numberBetween(1, 28),
            'user_id' => \App\Models\User::factory(),
            'ativo' => $this->faker->boolean,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Assinaturas;
use App\Models\Cadastro;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faturas>
 */
class FaturasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cadastro_id'   => $this->faker->numberBetween(1, Cadastro::count()),
            'assinatura_id' => $this->faker->numberBetween(1, Assinaturas::count()),
            'descricao'     => $this->faker->realTextBetween(10, 60),
            'vencimento'    => $this->faker->dateTimeThisYear(),
            'valor'         => $this->faker->randomFloat(2, 1, 2000)
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Cadastro;
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
            'cadastro_id'               => $this->faker->unique()->numberBetween(1, Cadastro::count()),
            'descricao'                 => $this->faker->realTextBetween(10, 60),
            'valor'                     => $this->faker->randomFloat(2, 1, 2000),
            'dia_fechamento_fatura'     => $this->faker->numberBetween(1, 31),
            'ativo'                     => $this->faker->boolean(50)
        ];
    }
}

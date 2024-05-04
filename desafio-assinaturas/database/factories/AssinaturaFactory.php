<?php

namespace Database\Factories;

use App\Models\Cadastro;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assinatura>
 */
class AssinaturaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cadastro = Cadastro::factory()->create();

        return [
            'descricao' => $this->faker->sentence(3),
            'valor' => $this->faker->randomNumber(4),
            'data_vencimento' => $this->faker->date(),
            'cadastro_id' => $cadastro->id,
            'flag_assinado' => $this->faker->randomElement(['PENDENTE', 'ASSINADO', 'CANCELADO']),
        ];
    }
}

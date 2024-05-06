<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fatura>
 */
class FaturaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'valor' => $this->faker->randomFloat(2, 10, 1000),
            'descricao' => $this->faker->sentence(3),
            'data_vencimento' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'data_pagamento' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'assinatura_id' => \App\Models\Assinaturas::factory(),
        ];
    }
}

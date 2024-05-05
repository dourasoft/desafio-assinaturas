<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\cadastro>
 */
class CadastroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'codigo'    => $this->faker->unique()->randomNumber(),
            'nome'      => $this->faker->name(),
            'email'     => $this->faker->unique()->email(),
            'telefone'  => $this->faker->phoneNumber(),
        ];
    }
}

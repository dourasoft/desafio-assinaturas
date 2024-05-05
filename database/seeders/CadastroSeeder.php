<?php

namespace Database\Seeders;

use App\Models\Cadastro;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class CadastroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $codigos = [
            'XYZKVT',
            'PUIOST',
            'TYVMSD',
            'HHDZXC',
            'QLSDFG'
        ];

        $telefones = [
            '82995946522',
            '82994846555',
            '11546523444',
            '99546244526',
            '15454568754'
        ];

        $faker = Faker::create();

        try {
            for ($i = 0; $i < 5; $i++) {
                Cadastro::create([
                    'codigo' => $codigos[$i],
                    'nome' => $faker->name,
                    'email' => $faker->email,
                    'telefone' => $telefones[$i],
                ]);
            }

            dd('Os cadastros foram inseridos com sucesso!');

        } catch (\Exception $e) {

            dd('Ocorreu um erro ao realizar a inserção dos cadastros '. $e->getMessage());
        }
    }
}

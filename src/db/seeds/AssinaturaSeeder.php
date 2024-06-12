<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class AssinaturaSeeder extends AbstractSeed
{


    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */

    public function getDependencies(): array
    {
       return [
           'CadastroSeeder'
       ];
    }

    public function run(): void
    {
        $data = [
            [
                "cadastro_id" => 1,
                "descricao" => "Assinatura de Pacote Basico",
                "valor" => 130.00,
                "vencimento" => "2024-06-30"
            ],
            [
                "cadastro_id" => 2,
                "descricao" => "Assinatura de Pacote Intermediario",
                "valor" => 150.00,
                "vencimento" => "2024-06-30"
            ],
            [
                "cadastro_id" => 3,
                "descricao" => "Assinatura de Pacote Plus",
                "valor" => 170.00,
                "vencimento" => "2024-06-30"
            ]
        ];

        $this
            ->table("assinaturas")
            ->insert($data)
            ->saveData();
    }
}

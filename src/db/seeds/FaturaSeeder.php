<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class FaturaSeeder extends AbstractSeed
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
            'CadastroSeeder',
            'AssinaturaSeeder'
        ];
    }

    public function run(): void
    {
        $data = [
            [
                "cadastro_id" => 1,
                "assinatura_id" => 1,
                "descricao" => "Fatura Pacote Basico",
                "vencimento" => '2024-06-23 23:59:00',
                "valor" => 130.00,
            ],
            [
                "cadastro_id" => 2,
                "assinatura_id" => 2,
                "descricao" => "Fatura Pacote Intermediario",
                "vencimento" => '2024-06-24 23:59:00',
                "valor" => 150.00,
            ],
            [
                "cadastro_id" => 3,
                "assinatura_id" => 3,
                "descricao" => "Fatura Pacote Plus",
                "vencimento" => '2024-07-02 23:59:00',
                "valor" => 170.00,
            ]
        ];

        $this
            ->table('faturas')
            ->insert($data)
            ->saveData();
    }
}

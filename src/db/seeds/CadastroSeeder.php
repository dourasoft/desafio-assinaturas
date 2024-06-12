<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class CadastroSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $data = [
            [
                "nome" => "Jorge",
                "email" => "jorge@gmail.com",
                "telefone" => "47984833454",
            ],
            [
                "nome" => "Greg",
                "email" => "greg@gmail.com",
                "telefone" => "47984833455",
            ],
            [
                "nome" => "Ademar",
                "email" => "ademar@gmail.com",
                "telefone" => "47984833456",
            ]
        ];
        $this
            ->table('cadastros')
            ->insert($data)
            ->saveData();
    }
}

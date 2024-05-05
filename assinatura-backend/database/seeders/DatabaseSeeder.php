<?php

namespace Database\Seeders;

use App\Models\Assinaturas;
use App\Models\Cadastro;
use App\Models\Faturas;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $numeroRegistros = 30;
        
        Cadastro::factory($numeroRegistros)->create();
        Assinaturas::factory($numeroRegistros)->create();
        Faturas::factory($numeroRegistros)->create();
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Http\Controllers\CadastroController;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('users')->insert([
            'name' => "dourasoft",
            "email" => "dourasoft@dourasoft.com.br",
            "password" => bcrypt(".Dourasoft123."),
            'created_at' => now()
        ]);

        DB::table('cadastros')->insert([
            [
                'nome' => "Roberto Vasconcelos",
                "codigo"=> Str::uuid(),
                "email" => "roberto@roberto.com.br",
                "telefone" => "5541111112222",
                'created_at' => now()
            ],
            [
                'nome' => "Pedro Rodrigo",
                "codigo"=> Str::uuid(),
                "email" => "pedro@pedro.com.br",
                "telefone" => "554433332222",
                'created_at' => now()
            ],
            [
                'nome' => "Jose Aldo",
                "codigo"=> Str::uuid(),
                "email" => "jose@jose.com.br",
                "telefone" => "5548444442222",
                'created_at' => now()
            ],
            [
                'nome' => "Cristiano Ronaldo",
                "codigo"=> Str::uuid(),
                "email" => "cr@cr.com.br",
                "telefone" => "5567888882222",
                'created_at' => now()
            ],
            [
                'nome' => "Anderson Silva",
                "codigo"=> Str::uuid(),
                "email" => "anderson@anderson.com.br",
                "telefone" => "5589777772222",
                'created_at' => now()
            ]
        ]);

        DB::table('assinaturas')->insert([
            [
                'cadastro_id' => 1,
                "descricao" => "Assinatura (Roberto Vasconcelos)",
                "valor" => 1005.32,
                "data_vencimento" => '2024-05-04',
                'created_at' => now()
            ],
            [
                'cadastro_id' => 2,
                "descricao" => "Assinatura (Pedro Rodrigo)",
                "valor" => 2305.49,
                "data_vencimento" => '2024-05-04',
                'created_at' => now()
            ],
            [
                'cadastro_id' => 3,
                "descricao" => "Assinatura (Jose Aldo)",
                "valor" => 12005.67,
                "data_vencimento" => '2024-05-04',
                'created_at' => now()
            ],
        ]);
    }
}

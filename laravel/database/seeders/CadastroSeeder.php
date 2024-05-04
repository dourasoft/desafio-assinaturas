<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Cadastro;

class CadastroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Vamos criar 10 registros fictícios
        for ($i = 1; $i <= 10; $i++) {
            Cadastro::firstOrCreate([
                'codigo' => 'COD'.$i,
                'nome' => 'Usuário '.$i,
                'email' => 'usuario'.$i.'@example.com',
                'telefone' => '(XX) 9XXXX-XXXX', // Você pode ajustar para números de telefone fictícios
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

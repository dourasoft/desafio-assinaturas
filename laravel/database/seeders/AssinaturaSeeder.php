<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assinatura;
use Carbon\Carbon;

class AssinaturaSeeder extends Seeder
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
            // Gerar uma data aleatória dentro do intervalo de 10 dias no futuro e 10 dias no passado
            $randomDate = Carbon::now()->addDays(rand(-10, 10));

            Assinatura::create([
                'id_tab_Cadastros' => $i, // Ajuste conforme necessário
                'descricao' => 'Assinatura '.$i,
                'vencimento' => $randomDate,
                'valor' => 100.00, // Ajuste conforme necessário
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

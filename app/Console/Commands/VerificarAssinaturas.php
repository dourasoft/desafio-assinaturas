<?php

namespace App\Console\Commands;

use App\Models\Assinatura;
use App\Models\Fatura;
use Carbon\Carbon;
use Illuminate\Console\Command;

class VerificarAssinaturas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:verificar-assinaturas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get all assignatures which expire in less than 10 days
        $assinaturas = Assinatura::whereDate('vencimento', '<=', Carbon::today()->addDays(10))
            ->where('status_fatura', 'aguardando')
            ->get();

        if (count($assinaturas) > 0) {
            $quantityAssinaturas = count($assinaturas);
            try {
                foreach ($assinaturas as $assinatura) {
                    Fatura::create([
                        'cadastro' => $assinatura->cadastro,
                        'assinatura' => $assinatura->id,
                        'descricao' => $assinatura->descricao,
                        'vencimento' => $assinatura->vencimento,
                        'valor' => $assinatura->valor,
                        'status' => 'pendente',
                    ]);

                    Assinatura::where('id', $assinatura->id)
                        ->update([
                            'status_fatura' => 'emitido',
                        ]);
                }

                $this->info('Foram lançadas '. $quantityAssinaturas . ' novas faturas');

            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Ocorreu um erro ao realizar o lançamento das faturas',
                    'info' => $e->getMessage(),
                    'code' => 500
                ], 500);
        }
        } else {
            $this->info('Não há assinaturas com data de vencimento menor ou igual a 10 dias');
        }
    }
}

<?php

namespace App\Console\Commands;

use App\Mail\FaturaMail;
use App\Models\Assinaturas;
use App\Models\Faturas;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ProcessarFaturas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:processar_faturas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica as assinaturas que vencem em 10 dias e converte elas em faturas.';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $dataVencimento         = Carbon::now()->addDay(10)->format("Y-m-d");
        $diaFechamentoFatura    = Carbon::createFromDate($dataVencimento)->format("d");

        $assinaturasVencendo =  Assinaturas::where('assinaturas.ativo', true)
            ->where('assinaturas.dia_fechamento_fatura', $diaFechamentoFatura)
            ->join('cadastros', 'assinaturas.cadastro_id', '=', 'cadastros.id')
            ->get();

        foreach ($assinaturasVencendo as $assinaturaVencendo) {

            $fatura = Faturas::create([
                'cadastro_id'   => $assinaturaVencendo->cadastro_id,
                'assinatura_id' => $assinaturaVencendo->id,
                'descricao'     => "Sua fatura acabou de chegar! O prazo para pagamento é até dia " . $dataVencimento . ".",
                'vencimento'    => $dataVencimento,
                'valor'         => $assinaturaVencendo->valor,
            ]);

            
            Mail::to($assinaturaVencendo->email)
                ->send(new FaturaMail([
                    'name'          => $assinaturaVencendo->nome,
                    'codigo'        => $assinaturaVencendo->codigo,
                    'descricao'     => $fatura->descricao,
                    'vencimento'    => Carbon::createFromDate($dataVencimento)->format("d-m-Y"),
                    'valor'         => $fatura->valor
                ]));
        }
    }
}

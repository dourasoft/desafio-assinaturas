<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\Assinatura\AssinaturaRepository;
use App\Repositories\Fatura\FaturaRepository;

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
        $repository_assinatura = new AssinaturaRepository();
        $assinaturas = $repository_assinatura->verificarAssinaturas();

        $repository_fatura = new FaturaRepository();
        foreach ($assinaturas as $assinatura) {
            $dados = [
                'id_tab_Cadastros' => $assinatura->id_tab_Cadastros,
                'id_tab_Assinaturas' => $assinatura->id,
                'descricao' => $assinatura->descricao,
                'vencimento' => $assinatura->vencimento,
                'valor' => $assinatura->valor,
            ];
            $repository_fatura->create($dados);
        }
    }
}

<?php

namespace App\Jobs;

use App\Models\Assinatura;
use App\Models\Fatura;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FaturaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $assinaturas = Assinatura::where('flag_assinado', 'PENDENTE')->get();

            if (count($assinaturas) >= 1) {

                foreach ($assinaturas as $assinatura) {
                    DB::beginTransaction();

                    $dataVencimento = $this->verificaVencimento($assinatura->data_vencimento);
                    logs()->debug("dataVencimento: ". $dataVencimento);
                    if (!$dataVencimento) {
                        continue;
                    }

                    $dataAtualizaAssinatura = $this->atualizaAssinatura($assinatura);
                    logs()->debug("dataAtualizaAssinatura: ". $dataAtualizaAssinatura);
                    if (!$dataAtualizaAssinatura) {
                        continue;
                    }

                    $geraFatura = $this->geraFatura($assinatura);
                    logs()->debug("geraFatura: ". $geraFatura);
                    if (!$geraFatura) {
                        DB::rollBack();
                        continue;
                    }

                    DB::commit();
                }

            }
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * Valida intervalode dias para geração de notas
     *
     * @param string $dataVencimento
     * @return boolean
     */
    private static function verificaVencimento(string $dataVencimento): bool
    {
        $intervaloDias = intval(env("DIAS_GERA_FATURA", 10));

        //data vencimento
        $dataCarbon = Carbon::createFromFormat('Y-m-d', $dataVencimento);

        //data atual
        $dataAtual = Carbon::now()->startOfDay();

        //intervalo
        $diferenca = $dataAtual->diffInDays($dataCarbon, false);

        if ($diferenca <= $intervaloDias) {
            //logs()->debug("TRUE");
            return true;
        }

        //logs()->debug("FALSE");
        return false;
    }

     /**
      * Atualiza tabela Assinatura
      *
      * @param Assinatura $assinatura
      * @return boolean
      */
    private static function atualizaAssinatura(Assinatura $assinatura): bool
    {
        try {
            return $assinatura->update([
                'flag_assinado' => 'ASSINADO'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * Gera cadastro na tabela Fatura
     *
     * @param Assinatura $assinatura
     * @return boolean
     */
    private static function geraFatura(Assinatura $assinatura): bool
    {
        try {
            return Fatura::insert([
                'cadastro_id' => $assinatura->cadastro_id,
                'assinatura_id' => $assinatura->id,
                'descricao' => "Fatura do cliente",
                'data_vencimento' => $assinatura->data_vencimento,
                'valor' => $assinatura->valor
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}

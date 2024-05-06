<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\{Assinaturas, Fatura};

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function (){
            $vencimento = now()->addDays(10);
            $dia = $vencimento->format('d');
            $mes = $vencimento->format('m');
            $assinaturas = Assinaturas::where('dia_vencimento', '=', $dia)->get();
            foreach ($assinaturas as $assinatura) {
                $fatura = new Fatura();
                $fatura->descricao = 'Fatura do mes '. $mes .' Assinatura:'. $assinatura->descricao;
                $fatura->data_vencimento = $vencimento;
                $fatura->valor = $assinatura->valor;
                $fatura->assinatura_id = $assinatura->id;
                $fatura->save();
            }
        }
        )->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

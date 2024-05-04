<?php

namespace App\Console;

use App\Jobs\FaturaJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->job(new FaturaJob())->everySecond();
        //$timer = strval(env('HORA_DIA_VALIDA_ASSINATURAS', '08:00'));
        //$schedule->job(new FaturaJob())->dailyAt($timer);        
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

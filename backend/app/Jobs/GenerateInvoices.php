<?php

namespace App\Jobs;

use App\Services\InvoiceService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateInvoices implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle(InvoiceService $invoiceService): void
    {
        try {
            $invoiceService->create($this->data);
        } catch (\Throwable $th) {
            Log::error('Erro ao gerar fatura: ' . $th->getMessage());
        }
    }
}

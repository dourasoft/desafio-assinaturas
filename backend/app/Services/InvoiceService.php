<?php

namespace App\Services;

use App\Repositories\InvoiceRepository;
use Carbon\Carbon;

class InvoiceService
{
    protected $invoiceRepository;
    protected $subscriptionService;

    public function __construct(InvoiceRepository $invoiceRepository, SubscriptionService $subscriptionService)
    {
        $this->invoiceRepository = $invoiceRepository;
        $this->subscriptionService = $subscriptionService;
    }

    public function getAll()
    {
        $data = $this->invoiceRepository->getAll();

        $result = [
            'success' => $data !== null,
            'data' => $data,
            'message' => null
        ];

        return $result;
    }

    public function create(array $data)
    {
        $subscription = $this->subscriptionService->getById($data['subscription_id']);

        $data['value'] = $subscription['data']['value'];

        $created = $this->invoiceRepository->create($data);

        $result = [
            'success' => $created !== null,
            'data' => $created,
            'message' => $created !== null ? 'Fatura criada com sucesso!' : 'Erro ao criar fatura'
        ];

        return $result;
    }

    public function getById($id)
    {
        $invoice = $this->invoiceRepository->getById($id);

        $result = [
            'success' => $invoice !== null,
            'data' => $invoice,
            'message' => $invoice !== null ? null : 'Fatura não encontrada'
        ];

        return $result;
    }

    public function getBySubscriptionId($id)
    {
        $invoices = $this->invoiceRepository->getById($id);

        $result = [
            'success' => $invoices !== null,
            'data' => $invoices,
            'message' => $invoices !== null ? null : 'Fatura não encontrada'
        ];

        return $result;
    }

    public function update($id, array $data)
    {
        $data['paid_at'] = isset($data['status']) && $data['status'] === 'PAID' ? Carbon::now() : null;

        $updated = $this->invoiceRepository->update($id, $data);

        $result = [
            'success' => !!$updated,
            'message' => $updated ? 'Atualização realizada com sucesso!' : 'Erro ao atualizar'
        ];

        return $result;
    }

    public function delete($id)
    {
        $deleted = $this->invoiceRepository->delete($id);

        $result = [
            'success' => !!$deleted,
            'message' => $deleted ? 'Fatura excluída com sucesso!' : 'Erro ao excluir fatura'
        ];

        return $result;
    }
}

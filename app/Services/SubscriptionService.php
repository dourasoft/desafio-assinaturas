<?php

namespace App\Services;

use App\Repositories\SubscriptionRepository;

class SubscriptionService
{
    protected $subscriptionRepository;

    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function getAll()
    {
        $data = $this->subscriptionRepository->getAll();

        $result = [
            'success' => $data !== null,
            'data' => $data,
            'message' => null
        ];

        return $result;
    }

    public function create(array $data)
    {
        $created = $this->subscriptionRepository->create($data);

        $result = [
            'success' => $created !== null,
            'data' => $created,
            'message' => $created !== null ? 'Assinatura criada com sucesso!' : 'Erro ao criar assinatura'
        ];

        return $result;
    }

    public function getById($id)
    {
        $subscription = $this->subscriptionRepository->getById($id);

        $result = [
            'success' => $subscription !== null,
            'data' => $subscription,
            'message' => $subscription !== null ? null : 'Assinatura não encontrada'
        ];

        return $result;
    }

    public function getByRegistrationId($id) {
        $subscriptions = $this->subscriptionRepository->getByRegistrationId($id);

        $result = [
            'success' => $subscriptions !== null,
            'data' => $subscriptions,
            'message' => $subscriptions !== null ? null : 'Não foi possível buscar as assinaturas'
        ];

        return $result;
    }

    public function update($id, array $data)
    {
        $updated = $this->subscriptionRepository->update($id, $data);

        $result = [
            'success' => !!$updated,
            'message' => $updated ? 'Atualização realizada com sucesso!' : 'Erro ao atualizar'
        ];

        return $result;
    }

    public function delete($id)
    {
        $deleted = $this->subscriptionRepository->delete($id);

        $result = [
            'success' => !!$deleted,
            'message' => $deleted ? 'Assinatura excluída com sucesso!' : 'Erro ao excluir assinatura'
        ];

        return $result;
    }

    public function getToGenerateInvoices() {
        $result = $this->subscriptionRepository->getToGenerateInvoices();

        return $result;
    }
}

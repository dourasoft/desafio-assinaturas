<?php

namespace App\Services;

use App\Repositories\RegistrationRepository;

class RegistrationService
{
    protected $registrationRepository;

    public function __construct(RegistrationRepository $registrationRepository)
    {
        $this->registrationRepository = $registrationRepository;
    }

    public function getAll()
    {
        $data = $this->registrationRepository->getAll();

        $result = [
            'success' => $data !== null,
            'data' => $data,
            'message' => null
        ];

        return $result;
    }

    public function create(array $data)
    {
        $created = $this->registrationRepository->create($data);

        $result = [
            'success' => $created !== null,
            'data' => $created,
            'message' => $created !== null ? 'Registro criado com sucesso!' : 'Erro ao criar registro'
        ];

        return $result;
    }

    public function getById($id)
    {
        $registration = $this->registrationRepository->getById($id);

        $result = [
            'success' => $registration !== null,
            'data' => $registration,
            'message' => $registration !== null ? null : 'Registro não encontrado'
        ];

        return $result;
    }

    public function update($id, array $data)
    {
        $updated = $this->registrationRepository->update($id, $data);

        $result = [
            'success' => !!$updated,
            'message' => $updated ? 'Atualização realizada com sucesso!' : 'Erro ao atualizar'
        ];

        return $result;
    }

    public function delete($id)
    {
        $deleted = $this->registrationRepository->delete($id);

        $result = [
            'success' => !!$deleted,
            'message' => $deleted ? 'Registro excluído com sucesso!' : 'Erro ao excluir registro'
        ];

        return $result;
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationsStoreRequest;
use App\Http\Requests\RegistrationsUpdateRequest;
use App\Services\RegistrationService;

class RegistrationsController extends Controller
{
    protected $registrationService;

    public function __construct(RegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    public function index()
    {
        return $this->registrationService->getAll();
    }

    public function store(RegistrationsStoreRequest $request)
    {
        $validatedForm = $request->validated();

        $result = $this->registrationService->create($validatedForm);

        if (!$result['success']) return response()->json($result, 400);

        return response()->json($result, 201);
    }

    public function show($id)
    {
        $result = $this->registrationService->getById($id);

        if (!$result['success']) return response()->json($result, 404);

        return response()->json($result, 200);
    }

    public function update(RegistrationsUpdateRequest $request, $id)
    {
        $validatedForm = $request->validated();

        $registrationExists = $this->registrationService->getById($id);

        if (!$registrationExists['data']) return response()->json(['success' => false, 'message' => 'Registro não encontrado'], 404);

        $result = $this->registrationService->update($id, $validatedForm);

        if (!$result['success']) return response()->json($result, 400);

        return response()->json($result, 200);
    }

    public function destroy($id)
    {
        $registrationExists = $this->registrationService->getById($id);

        if (!$registrationExists['data']) return response()->json(['success' => false, 'message' => 'Registro não encontrado'], 404);

        $result = $this->registrationService->delete($id);

        if (!$result['success']) return response()->json($result, 400);

        return response()->json($result, 200);
    }
}

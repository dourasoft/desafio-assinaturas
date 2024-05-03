<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriptionsStoreRequest;
use App\Http\Requests\SubscriptionsUpdateRequest;
use App\Services\SubscriptionService;

class SubscriptionsController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function index()
    {
        return $this->subscriptionService->getAll();
    }

    public function store(SubscriptionsStoreRequest $request)
    {
        $validatedForm = $request->validated();

        $result = $this->subscriptionService->create($validatedForm);

        if (!$result['success']) return response()->json($result, 400);

        return response()->json($result, 201);
    }

    public function show($id)
    {
        $result = $this->subscriptionService->getById($id);

        if (!$result['success']) return response()->json($result, 404);

        return response()->json($result, 200);
    }

    public function getByRegistrationId($id) {
        $result = $this->subscriptionService->getByRegistrationId($id);

        if (!$result['success']) return response()->json($result, 404);

        return response()->json($result, 200);
    }

    public function update(SubscriptionsUpdateRequest $request, $id)
    {
        $validatedForm = $request->validated();

        $subscriptionExists = $this->subscriptionService->getById($id);

        if (!$subscriptionExists['data']) return response()->json(['success' => false, 'message' => 'Assinatura não encontrada'], 404);

        $result = $this->subscriptionService->update($id, $validatedForm);

        if (!$result['success']) return response()->json($result, 400);

        return response()->json($result, 200);
    }

    public function destroy($id)
    {
        $subscriptionExists = $this->subscriptionService->getById($id);

        if (!$subscriptionExists['data']) return response()->json(['success' => false, 'message' => 'Assinatura não encontrada'], 404);

        $result = $this->subscriptionService->delete($id);

        if (!$result['success']) return response()->json($result, 400);

        return response()->json($result, 200);
    }
}

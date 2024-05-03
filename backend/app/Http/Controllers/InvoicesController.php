<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoicesStoreRequest;
use App\Http\Requests\InvoicesUpdateRequest;
use App\Services\InvoiceService;

class InvoicesController extends Controller
{
    protected $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function index()
    {
        return $this->invoiceService->getAll();
    }

    public function store(InvoicesStoreRequest $request)
    {
        $validatedForm = $request->validated();

        $result = $this->invoiceService->create($validatedForm);

        if (!$result['success']) return response()->json($result, 400);

        return response()->json($result, 201);
    }

    public function show($id)
    {
        $result = $this->invoiceService->getById($id);

        if (!$result['success']) return response()->json($result, 404);

        return response()->json($result, 200);
    }

    public function getBySubscriptionId($id) {
        $result = $this->invoiceService->getBySubscriptionId($id);

        if (!$result['success']) return response()->json($result, 404);

        return response()->json($result, 200);
    }

    public function update(InvoicesUpdateRequest $request, $id)
    {
        $validatedForm = $request->validated();

        $invoiceExists = $this->invoiceService->getById($id);

        if (!$invoiceExists['data']) return response()->json(['success' => false, 'message' => 'Fatura não encontrada'], 404);

        $result = $this->invoiceService->update($id, $validatedForm);

        if (!$result['success']) return response()->json($result, 400);

        return response()->json($result, 200);
    }

    public function destroy($id)
    {
        $invoiceExists = $this->invoiceService->getById($id);

        if (!$invoiceExists['data']) return response()->json(['success' => false, 'message' => 'Fatura não encontrada'], 404);

        $result = $this->invoiceService->delete($id);

        if (!$result['success']) return response()->json($result, 400);

        return response()->json($result, 200);
    }
}

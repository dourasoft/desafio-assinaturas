<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Resources\InvoiceCollection;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Models\Register;
use App\Models\Subscription;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InvoiceController extends Controller
{
    use ApiResponser;

    /**
     * Display a listing of the resource.
     */
    public function index(Register $register, Subscription $subscription)
    {
        $subscriptions = Invoice::with('register', 'subscription')->where('register_id', '=', $register->id)->where('subscription_id', '=', $subscription->id)->paginate(10);
        return new InvoiceCollection($subscriptions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request, Register $register, Subscription $subscription)
    {
        $invoice = Invoice::create($request->validated());
        $invoice->load('register', 'subscription');
        return new InvoiceResource($invoice);
    }

    /**
     * Display the specified resource.
     */
    public function show(Register $register, Subscription $subscription, Invoice $invoice)
    {
        return new InvoiceResource($invoice->load('register', 'subscription'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Register $register, Subscription $subscription, Invoice $invoice)
    {
        $invoice->fill($request->validated());
        $invoice->save();
        return new InvoiceResource($invoice->load('register', 'subscription'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Register $register, Subscription $subscription, Invoice $invoice)
    {
        try {
            $invoice->deleteOrFail();
        } catch (NotFoundHttpException $th) {
            return $this->errorResponse(Response::$statusTexts[Response::HTTP_NOT_FOUND], Response::HTTP_NOT_FOUND);
        }
        return response()->json(['data' => ["message" => "Invoice successfully deleted."]], Response::HTTP_OK);
    }
}

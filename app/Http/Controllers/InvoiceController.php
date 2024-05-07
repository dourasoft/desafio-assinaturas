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
use Symfony\Component\Translation\Exception\NotFoundResourceException;

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

        try {
            if ($request->validated('register_id') != $register->id || $request->validated('subscription_id') != $subscription->id) {
                throw new NotFoundHttpException('Subscription does not belong to the specified register.');
            }
            $invoice = Invoice::create($request->validated());
            $invoice->load('register', 'subscription');
            return new InvoiceResource($invoice);
        } catch (NotFoundHttpException $th) {
            return $this->errorResponse($th->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Register $register, Subscription $subscription, Invoice $invoice)
    {
        try {
            $invoice = Invoice::with('register', 'subscription')->where('register_id', '=', $invoice->register_id)->where('subscription_id', '=', $invoice->subscription_id)->where('id', '=', $invoice->id)->first();

            if ($invoice->register_id !== $register->id || $invoice->subscription_id !== $subscription->id) {
                throw new NotFoundHttpException('Subscription does not belong to the specified register.');
            }
            return new InvoiceResource($invoice);
        } catch (NotFoundHttpException $th) {
            return $this->errorResponse($th->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Register $register, Subscription $subscription, Invoice $invoice)
    {

        try {
            $invoice = Invoice::where('register_id', '=', $invoice->register_id)->where('subscription_id', '=', $invoice->subscription_id)->where('id', '=', $invoice->id)->first();

            if ($invoice->register_id !== $register->id || $invoice->subscription_id !== $subscription->id) {
                throw new NotFoundHttpException('Subscription does not belong to the specified register.');
            }
            $invoice->fill($request->validated());
            $invoice->save();
            return new InvoiceResource($invoice->load('register', 'subscription'));
        } catch (NotFoundHttpException $th) {
            return $this->errorResponse($th->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Register $register, Subscription $subscription, Invoice $invoice)
    {
        try {
            $invoice = Invoice::where('register_id', '=', $invoice->register_id)->where('subscription_id', '=', $invoice->subscription_id)->where('id', '=', $invoice->id)->first();
            if ($invoice->register_id !== $register->id || $invoice->subscription_id !== $subscription->id) {
                throw new NotFoundHttpException('Subscription does not belong to the specified register.');
            }
            $invoice->deleteOrFail();
        } catch (NotFoundHttpException $th) {
            return $this->errorResponse($th->getMessage(), Response::HTTP_NOT_FOUND);
        }
        return response()->json(['data' => ["message" => "Invoice successfully deleted."]], Response::HTTP_OK);
    }
}

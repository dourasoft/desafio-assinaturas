<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Requests\UpdateSubscriptionRequest;
use App\Http\Resources\SubscriptionCollection;
use App\Http\Resources\SubscriptionResource;
use App\Models\Register;
use App\Models\Subscription;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SubscriptionController extends Controller
{
    use ApiResponser;

    /**
     * Display a listing of the resource.
     */
    public function index(Register $register)
    {
        $subscriptions = Subscription::with('register', 'invoice')->where('register_id', '=', $register->id)->paginate();
        return new SubscriptionCollection($subscriptions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubscriptionRequest $request, Register $register)
    {
        $subscription = Subscription::create($request->validated());
        $subscription->load('register');
        return new SubscriptionResource($subscription);
    }

    /**
     * Display the specified resource.
     */
    public function show(Register $register, Subscription $subscription)
    {
        $subscription->load('register', 'invoice');
        return new SubscriptionResource($subscription);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubscriptionRequest $request, Register $register, Subscription $subscription)
    {
        $subscription->fill($request->validated());
        $subscription->save();
        return new SubscriptionResource($subscription->load('register', 'invoice'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Register $register, Subscription $subscription)
    {
        try {
            $subscription->deleteOrFail();
        } catch (NotFoundHttpException $th) {
            return $this->errorResponse(Response::$statusTexts[Response::HTTP_NOT_FOUND], Response::HTTP_NOT_FOUND);
        }
        return response()->json(['data' => ["message" => "Subscription successfully deleted."]], Response::HTTP_OK);
    }
}

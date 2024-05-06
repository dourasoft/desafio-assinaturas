<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegisterRequest;
use App\Http\Requests\UpdateRegisterRequest;
use App\Http\Resources\RegisterCollection;
use App\Http\Resources\RegisterResource;
use App\Models\Register;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RegisterController extends Controller
{
    use ApiResponser;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new RegisterCollection(Register::with('subscriptions.invoice')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRegisterRequest $request)
    {
        return new RegisterResource(Register::create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Register $register)
    {
        return new RegisterResource($register->load('subscriptions.invoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRegisterRequest $request, Register $register)
    {
        $register->fill($request->validated());
        $register->save();
        return new RegisterResource($register->load('subscriptions.invoice'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Register $register)
    {
        try {
            $register->deleteOrFail();
        } catch (NotFoundHttpException $th) {
            return $this->errorResponse(Response::$statusTexts[Response::HTTP_NOT_FOUND], Response::HTTP_NOT_FOUND);
        }
        return response()->json(['data' => ["message" => "Register successfully deleted."]], Response::HTTP_OK);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegisterRequest;
use App\Http\Requests\UpdateRegisterRequest;
use App\Http\Resources\RegisterCollection;
use App\Http\Resources\RegisterResource;
use App\Models\Register;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new RegisterCollection(Register::all());
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
        return new RegisterResource($register);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRegisterRequest $request, Register $register)
    {
        $register->fill($request->validated());
        $register->save();
        return new RegisterResource($register);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Register $register)
    {
        $register->delete();
        return response()->noContent();
    }
}

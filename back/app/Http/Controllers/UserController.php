<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\{NewUserRequest, UpdateUserRequest};


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::orderBy('id', 'desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewUserRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->codigo = rand(1000000, 9999999);
        $user->email = $request->email;
        $user->password = bcrypt(rand(1000000, 9999999));
        $user->telefone = $request->telefone;
        $user->save();
        return response()->json($user, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->name = $request->name;
        $user->telefone = $request->telefone;
        $user->update();
        return response()->json($user, 200);       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $assinaturas = $user->assinaturas;
        foreach ($assinaturas as $assinatura) {
            $faturas = $assinatura->faturas;
            foreach ($faturas as $fatura) {
                $fatura->delete();
            }
            $assinatura->delete();
        }
        $user->delete();
        return response()->json(null, 204);        
    }
}

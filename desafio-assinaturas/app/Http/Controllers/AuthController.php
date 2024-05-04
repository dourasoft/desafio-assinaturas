<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Library\Response;
use App\Models\User;

/**
 * AuthController class
 */
class AuthController extends Controller
{
    /**
     * Função responsável por efetuar o Login via Sanctum
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        $credentials = Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        if ($credentials) {

            /**  @var Illuminate\Support\Facades\Auth $user */
            $user = Auth::user();

            $token = $user->createToken($request->email)->plainTextToken;

            Response::json([
                'token' => $token,
                "user" => $user
            ], 200);
        } else {
            Response::json(['error' => 'Credenciais incorretas'], 500);
        }
    }

    /**
     * Função responsável por efetuar o Logout via Sanctum e destruir o token ativo
     *
     * @param Request $request
     * @return void
     */
    public function logout(Request $request)
    {
        if ($request->user()->tokens()->delete()) {
            Response::success();
        }

        Response::json(['warning' => 'Não foi possivel efetuar o logout'], 400);
    }
}

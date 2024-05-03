<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * Desenvolva uma api RESTful em PHP para criar, atualizar, deletar e listar todos os
     * usuários. As informações devem ser salvas em um banco de dados MySQL.
     * O endpoint deve retornar os dados em formato JSON e permitir operações GET, POST,
     * PUT e DELETE para manipular os registros de usuário.
     * Considere aspectos como segurança, validação de entrada e tratamento de erros. O exame
     * deverá ser entregue através do link do projeto no Git.
     * Desejável que utilize Laravél ou CodeIgniter 3.
     */


    // GET
    public function getAllUsers()
    {
        try {
            $users = User::all();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocorreu um erro ao realizar a consulta.',
                'info' => $e->getMessage(),
                'code' => 500
            ], 500);
        };

        if (count($users) == 0) {
            return response()->json([
                'message' => 'Ainda não há usuários cadastrados.',
                'code' => 204
            ], 204);
        }

        return response()->json([
            'data' => $users,
            'code' => 200
        ], 200);
    }

    // GET
    public function getUser($id = null)
    {
        if (!is_numeric($id)) return response()->json(['message' => 'O ID deve ser um número inteiro', 'code' => 400], 400);

        if(is_null($id)) return response()->json(['message' => 'Você esqueceu de informar o ID do usuário', 'code' => 400], 400);

        try {
            $userExist = User::where('id', $id)
                ->exists();

            if (!$userExist) return response()->json(['message' => 'O ID informado não é de um usuário cadastrado', 'code' => 406], 406);

            $users = User::find($id);

            if ($users == null) {
                return response()->json([
                    'message' => 'O usuário buscado não existe',
                    'code' => 204
                ], 204);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocorreu um erro ao realizar a consulta.',
                'info' => $e->getMessage(),
                'code' => 500
            ], 500);
        };

        return response()->json([
            'data' => $users,
            'code' => 200
        ], 200);
    }

    // POST
    public function insertUsers(Request $request)
    {
        if ($this->validateEmptyField($request)) return response()->json([
            'message' => 'os campos: name, email e password são obrigatórios',
            'code' => 400
        ], 400);

        if ($this->validatorFields($request) !== false) {
            return response()->json([
                'errors' => $this->validatorFields($request)->errors(),
                'code' => 422], 422);
        }

        try {
            $userExist = User::where('email', $request->email)
                ->exists();

            if ($userExist) return response()->json(['message' => 'Já existe um usuário cadastrado com o mesmo email', 'code' => 406], 406);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            return response()->json([
                'message'=> 'O usuário foi inserido com sucesso!',
                'data' => $user,
                'code' => 201
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocorreu um erro ao realizar a inserção',
                'info' => $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }

    // PUT
    public function updateUser(Request $request, $id = null)
    {
        if (!is_numeric($id)) return response()->json(['message' => 'O ID deve ser um número inteiro', 'code' => 400], 400);

        if ($this->validateEmptyField($request)) return response()->json([
            'message' => 'os campos: name, email e password são obrigatórios',
            'code' => 400
        ], 400);

        if ($this->validatorFields($request) !== false) {
            return response()->json([
                'errors' => $this->validatorFields($request)->errors(),
                'code' => 422], 422);
        }

        try {
            if(is_null($id)) return response()->json(['message' => 'Você esqueceu de informar o ID do usuário'], 400);

            $userExist = User::where('id', $id)
                ->exists();

            if (!$userExist) return response()->json(['message' => 'O ID do usário informado não existe', 'code' => 406], 406);

            User::where('id', $id)
              ->update([
                'name' => $request->name,
                'email'=> $request->email,
                'password'=> bcrypt($request->password),
            ]);

            return response()->json([
                'message'=> 'O usuário foi atualizado com sucesso!',
                'data' => User::find($id),
                'code' => 201
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocorreu um erro ao realizar a atualização',
                'info' => $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }

    // DELETE
    public function deleteUser($id = null)
    {
        if (!is_numeric($id)) return response()->json(['message' => 'O ID deve ser um número inteiro', 'code' => 400], 400);

        if(is_null($id)) return response()->json(['message' => 'Você esqueceu de informar o ID do usuário', 'code' => 400], 400);

        try {
            $userExist = User::where('id', $id)
                    ->exists();

            if (!$userExist) return response()->json(['message' => 'O ID informado não é de um usuário cadastrado', 'code' => 406], 406);

            User::where('id', $id)->delete();

            return response()->json([
                'message'=> 'O usuário foi deletado com sucesso!',
                'data' => User::all(),
                'code' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocorreu um erro ao tentar deletar o usuário',
                'info' => $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }

    function validateEmptyField($request)
    {
        if (!isset($request->email) || !isset($request->name) || !isset($request->password)) {
            return true;
        } else {
            return false;
        }
    }

    function validatorFields($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        return $validator->fails() ? $validator : false;
    }
}

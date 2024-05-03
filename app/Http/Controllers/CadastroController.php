<?php

namespace App\Http\Controllers;

use App\Models\cadastro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CadastroController extends Controller
{
    // GET
    public function getAllcadastros()
    {
        try {
            $cadastros = Cadastro::all();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocorreu um erro ao realizar a consulta.',
                'info' => $e->getMessage(),
                'code' => 500
            ], 500);
        };

        if (count($cadastros) == 0) {
            return response()->json([
                'message' => 'Ainda não há cadastros inseridos.',
                'code' => 204
            ], 204);
        }

        return response()->json([
            'data' => $cadastros,
            'code' => 200
        ], 200);
    }

    // GET
    public function getcadastro($id = null)
    {
        if (!is_numeric($id)) return response()->json(['message' => 'O ID deve ser um número inteiro', 'code' => 400], 400);

        if(is_null($id)) return response()->json(['message' => 'Você esqueceu de informar o ID do cadastro', 'code' => 400], 400);

        try {
            $cadastroExist = Cadastro::where('id', $id)
                ->exists();

            if (!$cadastroExist) return response()->json(['message' => 'O ID informado não é de um cadastro válido', 'code' => 406], 406);

            $cadastros = Cadastro::find($id);

            if ($cadastros == null) {
                return response()->json([
                    'message' => 'O cadastro buscado não existe',
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
            'data' => $cadastros,
            'code' => 200
        ], 200);
    }

    // POST
    public function insertcadastros(Request $request)
    {
        if ($this->validateEmptyField($request)) return response()->json([
            'message' => 'os campos: nome, email e telefone e codigo são obrigatórios',
            'code' => 400
        ], 400);

        if ($this->validatorFields($request) !== false) {
            return response()->json([
                'errors' => $this->validatorFields($request)->errors(),
                'code' => 422], 422);
        }

        try {
            $cadastroExist = Cadastro::where('email', $request->email)
                ->orWhere('codigo', $request->codigo)
                ->exists();

            if ($cadastroExist) return response()->json(['message' => 'Já existe um cadastro com o mesmo email ou codigo', 'code' => 406], 406);

            $cadastro = Cadastro::create([
                'codigo'=> $request->codigo,
                'nome' => $request->nome,
                'email' => $request->email,
                'telefone' => $request->telefone,
            ]);

            return response()->json([
                'message'=> 'O cadastro foi inserido com sucesso!',
                'data' => $cadastro,
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
    public function updatecadastro(Request $request, $id = null)
    {
        if (!is_numeric($id)) return response()->json(['message' => 'O ID deve ser um número inteiro', 'code' => 400], 400);

        if ($this->validateEmptyField($request)) return response()->json([
            'message' => 'os campos: codigo, nome, email e telefone são obrigatórios',
            'code' => 400
        ], 400);

        if ($this->validatorFields($request) !== false) {
            return response()->json([
                'errors' => $this->validatorFields($request)->errors(),
                'code' => 422], 422);
        }

        try {
            if(is_null($id)) return response()->json(['message' => 'Você esqueceu de informar o ID do cadastro'], 400);

            $cadastroExist = Cadastro::where('id', $id)
                ->exists();

            if (!$cadastroExist) return response()->json(['message' => 'O ID do cadastro informado não existe', 'code' => 406], 406);

            Cadastro::where('id', $id)
              ->update([
                'codigo'=> $request->codigo,
                'nome' => $request->nome,
                'email'=> $request->email,
                'telefone'=> $request->telefone,
            ]);

            return response()->json([
                'message'=> 'O cadastro foi atualizado com sucesso!',
                'data' => Cadastro::find($id),
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
    public function deleteCadastro($id = null)
    {
        if (!is_numeric($id)) return response()->json(['message' => 'O ID deve ser um número inteiro', 'code' => 400], 400);

        if(is_null($id)) return response()->json(['message' => 'Você esqueceu de informar o ID do cadastro', 'code' => 400], 400);

        try {
            $cadastroExist = Cadastro::where('id', $id)
                    ->exists();

            if (!$cadastroExist) return response()->json(['message' => 'O ID informado não é de um cadastro válido', 'code' => 406], 406);

            Cadastro::where('id', $id)->delete();

            return response()->json([
                'message'=> 'O cadastro com ID '. $id .' foi deletado com sucesso!',
                'data' => cadastro::all(),
                'code' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocorreu um erro ao tentar deletar o cadastro',
                'info' => $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }

    function validateEmptyField($request)
    {
        if (!isset($request->email) || !isset($request->codigo) || !isset($request->nome) || !isset($request->telefone)) {
            return true;
        } else {
            return false;
        }
    }

    function validatorFields($request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|string|min:4',
            'nome' => 'required|string',
            'email' => 'required|email',
            'telefone' => 'required|string|min:8',
        ]);

        return $validator->fails() ? $validator : false;
    }
}

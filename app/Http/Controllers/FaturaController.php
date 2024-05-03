<?php

namespace App\Http\Controllers;

use App\Models\Fatura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FaturaController extends Controller
{
    // GET
    public function getAllfaturas()
    {
        try {
            $faturas = Fatura::all();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocorreu um erro ao realizar a consulta.',
                'info' => $e->getMessage(),
                'code' => 500
            ], 500);
        };

        if (count($faturas) == 0) {
            return response()->json([
                'message' => 'Ainda não há faturas cadastradas.',
                'code' => 204
            ], 204);
        }

        return response()->json([
            'data' => $faturas,
            'code' => 200
        ], 200);
    }

    // GET
    public function getFatura($id = null)
    {
        if (!is_numeric($id)) return response()->json(['message' => 'O ID deve ser um número inteiro', 'code' => 400], 400);

        if(is_null($id)) return response()->json(['message' => 'Você esqueceu de informar o ID da fatura', 'code' => 400], 400);

        try {
            $faturaExist = Fatura::where('id', $id)
                ->exists();

            if (!$faturaExist) return response()->json(['message' => 'O ID informado não é de uma fatura válida', 'code' => 406], 406);

            $faturas = Fatura::find($id);

            if ($faturas == null) {
                return response()->json([
                    'message' => 'A fatura buscada não existe',
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
            'data' => $faturas,
            'code' => 200
        ], 200);
    }

    // POST
    public function insertFatura(Request $request)
    {
        // return $request;
        if ($this->validateEmptyField($request)) return response()->json([
            'message' => 'os campos: cadastro, assinatura, descricao, vencimento, valor e status são obrigatórios',
            'code' => 400
        ], 400);

        if ($this->validatorFields($request) !== false) {
            return response()->json([
                'errors' => $this->validatorFields($request)->errors(),
                'code' => 422], 422);
        }

        try {
            $fatura = Fatura::create([
                'cadastro'=> $request->cadastro,
                'assinatura' => $request->assinatura,
                'descricao' => $request->descricao,
                'vencimento' => $request->vencimento,
                'valor' => $request->valor,
                'status' => $request->status,
            ]);

            return response()->json([
                'message'=> 'A fatura foi inserida com sucesso!',
                'data' => $fatura,
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
    public function updateFatura(Request $request, $id = null)
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
            if(is_null($id)) return response()->json(['message' => 'Você esqueceu de informar o ID da fatura'], 400);

            $faturaExist = Fatura::where('id', $id)
                ->exists();

            if (!$faturaExist) return response()->json(['message' => 'O ID da fatura informada não existe', 'code' => 406], 406);

            Fatura::where('id', $id)
              ->update([
                'codigo'=> $request->codigo,
                'nome' => $request->nome,
                'email'=> $request->email,
                'telefone'=> $request->telefone,
            ]);

            return response()->json([
                'message'=> 'O fatura foi atualizado com sucesso!',
                'data' => Fatura::find($id),
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
    public function deletefatura($id = null)
    {
        if (!is_numeric($id)) return response()->json(['message' => 'O ID deve ser um número inteiro', 'code' => 400], 400);

        if(is_null($id)) return response()->json(['message' => 'Você esqueceu de informar o ID da fatura', 'code' => 400], 400);

        try {
            $faturaExist = Fatura::where('id', $id)
                    ->exists();

            if (!$faturaExist) return response()->json(['message' => 'O ID informado não é de uma fatura válida', 'code' => 406], 406);

            Fatura::where('id', $id)->delete();

            return response()->json([
                'message'=> 'A fatura com ID '. $id .' foi deletada com sucesso!',
                'data' => Fatura::all(),
                'code' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocorreu um erro ao tentar deletar a fatura',
                'info' => $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }

    function validateEmptyField($request)
    {
        if (!isset($request->cadastro) || !isset($request->assinatura) || !isset($request->descricao) || !isset($request->vencimento) || !isset($request->valor) || !isset($request->status)) {
            return true;
        } else {
            return false;
        }
    }

    function validatorFields($request)
    {
        $validator = Validator::make($request->all(), [
            'cadastro' => 'required|string|min:4',
            'assinatura' => 'required|integer',
            'descricao' => 'required|string',
            'vencimento' => 'required|date',
            'valor' => 'required|integer',
            'status' => 'required|string|in:pago,pendente',
        ]);

        return $validator->fails() ? $validator : false;
    }
}

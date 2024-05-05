<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cadastro\CreateCadastroFormRequest;
use App\Http\Requests\Cadastro\UpdateOrDeleteCadastroFormRequest;
use App\Http\Resources\CadastroResource;
use App\Models\Cadastro;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Throwable;

class CadastroController extends Controller
{
    public static function index()
    {
        return CadastroResource::collection(Cadastro::all());
    }

    public static function show(UpdateOrDeleteCadastroFormRequest $request)
    {
        return CadastroResource::make(Cadastro::find($request->id));
    }

    public static function store(CreateCadastroFormRequest $request)
    {

        try {

            DB::beginTransaction();

            $cadastro = Cadastro::create([
                'codigo'    => $request->codigo,
                'nome'      => $request->nome,
                'email'     => $request->email,
                'telefone'  => $request->telefone
            ]);

            DB::commit();
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(['data' => ['error' =>  'Erro ao inserir o cadastro: ' . $th->getMessage()]]);
        }

        return response()->json(['sucess' => true, 'message' => 'Cadastro inserido com sucesso.', 'data' =>  CadastroResource::make($cadastro)], Response::HTTP_OK);
    }

    public static function update(UpdateOrDeleteCadastroFormRequest $request)
    {
        $cadastro = Cadastro::find($request->id);

        if (empty($cadastro)) {
            return response()->json(['sucess' => false, 'message' => 'Cadastro não encontrado.', 'data' => []], Response::HTTP_NO_CONTENT);
        }

        $cadastro->codigo   = isset($request->codigo) ? $request->codigo :  $cadastro->codigo;
        $cadastro->nome     = isset($request->nome) ? $request->nome : $cadastro->nome;
        $cadastro->email    = isset($request->email) ? $request->email : $cadastro->email;
        $cadastro->telefone = isset($request->telefone) ? $request->telefone : $cadastro->telefone;
        $cadastro->ativo    = isset($request->ativo) ? $request->ativo : $cadastro->ativo;
        $cadastro->save();

        return response()->json(['sucess' => true, 'message' => 'Cadastro atualizado com sucesso.', 'data' =>  CadastroResource::make($cadastro)], Response::HTTP_OK);
    }

    public static function destroy(UpdateOrDeleteCadastroFormRequest $request)
    {
        $cadastro = Cadastro::find($request->id);

        if (empty($cadastro)) {
            return response()->json(['sucess' => false, 'message' => 'Cadastro não encontrado.', 'data' => []], Response::HTTP_NO_CONTENT);
        }

        $cadastro->ativo = false;
        $cadastro->save();

        return response()->json(['sucess' => true, 'message' => 'Cadastro deletado com sucesso.', 'data' =>  CadastroResource::make($cadastro)], Response::HTTP_OK);
    }
}

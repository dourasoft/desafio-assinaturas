<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCadastroFormRequest;
use App\Http\Resources\CadastroResource;
use App\Models\Cadastro;
use Throwable;

class CadastroController extends Controller
{
    public static function getAll(){
        return CadastroResource::collection(Cadastro::where('ativo', true)->get());
    }

    public static function getById($id){
        return CadastroResource::make(Cadastro::find($id));
    }

    public static function getByCodigo($codigo){
        return CadastroResource::make(Cadastro::where('codigo', $codigo)->where('ativo', true)->first());
    }

    public static function store(CreateCadastroFormRequest $request){

        try {

            $cadastro = Cadastro::create([
                'codigo'    => $request->codigo,
                'nome'      => $request->nome,
                'email'     => $request->email,
                'telefone'  => $request->telefone,
                'ativo'     => isset($request->ativo) ?? true
            ]);

        } catch (Throwable $th) {
            return response()->json(['data' => ['error' =>  'Erro ao inserir o cadastro: ' . $th->getMessage()]]);
        }

        return CadastroResource::make($cadastro);
    }
}

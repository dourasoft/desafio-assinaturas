<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assinaturas;
use App\Http\Requests\NewAssinaturaRequest;

class AssinaturasController extends Controller
{
    
    public function index()
    {
        return Assinaturas::with('user')->orderBy('id', 'desc')->get();
    }

    public function store(NewAssinaturaRequest $request)
    {
        $assinatura = new Assinaturas();
        $assinatura->descricao = $request->descricao;
        $assinatura->valor = $request->valor;
        $assinatura->dia_vencimento = $request->dia_vencimento;
        $assinatura->user_id = $request->user_id;
        $assinatura->ativo = $request->ativo;
        $assinatura->save();
        return response()->json($assinatura->load('user'), 201);
    }

    public function update(NewAssinaturaRequest $request, Assinaturas $assinatura)
    {
        $assinatura->descricao = $request->descricao;
        $assinatura->valor = $request->valor;
        $assinatura->dia_vencimento = $request->dia_vencimento;
        $assinatura->user_id = $request->user_id;
        $assinatura->ativo = $request->ativo;
        $assinatura->update();
        return response()->json($assinatura->load('user'), 200);       
    }

    public function destroy(Assinaturas $assinatura)
    {
        $fatutas = $assinatura->faturas;
        foreach ($fatutas as $fatura) {
            $fatura->delete();
        }
        $assinatura->delete();
        return response()->json(null, 204);        
    }
}

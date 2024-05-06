<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fatura;
use App\Http\Requests\NewFaturaRequest;

class FaturaController extends Controller
{
    public function index()
    {
        return Fatura::orderBy('id', 'desc')->with('assinatura.user')->get();
    }

    public function store(NewFaturaRequest $request)
    {
        $fatura = new Fatura();
        $fatura->valor = $request->valor;
        $fatura->descricao = $request->descricao;
        $fatura->data_vencimento = date('Y-m-d', strtotime($request->data_vencimento));;
        $fatura->assinatura_id = $request->assinatura_id;
        $fatura->save();
        
        return response()->json(Fatura::find($fatura->id)->load('assinatura.user'), 201);
    }

    public function update(NewFaturaRequest $request, Fatura $fatura)
    {
        $fatura->valor = $request->valor;
        $fatura->descricao = $request->descricao;
        $fatura->data_vencimento = date('Y-m-d', strtotime($request->data_vencimento));
        $fatura->data_pagamento = date('Y-m-d', strtotime($request->data_pagamento));
        $fatura->assinatura_id = $request->assinatura_id;
        $fatura->status = $request->status;
        $fatura->update();
        return response()->json(Fatura::find($fatura->id)->load('assinatura.user'), 200);       
    }

    public function destroy(Fatura $fatura)
    {
        $fatura->delete();
        return response()->json(null, 204);        
    }
}

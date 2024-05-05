<?php

namespace App\Http\Controllers;

use App\Http\Requests\Fatura\CreateFaturaRequest;
use App\Http\Requests\Fatura\UpdateOrDeleteFaturaRequest;
use App\Http\Resources\FaturaResource;
use App\Models\Faturas;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Throwable;

class FaturasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return FaturaResource::collection(Faturas::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateFaturaRequest $request)
    {
        try {

            DB::beginTransaction();

            $fatura = Faturas::create([
                'cadastro_id'   => $request->cadastro_id,
                'assinatura_id' => $request->assinatura_id,
                'descricao'     => $request->descricao,
                'vencimento'    => $request->vencimento,
                'valor'         => $request->valor
            ]);

            DB::commit();
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(['data' => ['error' =>  'Erro ao gerar a fatura: ' . $th->getMessage()]]);
        }

        return response()->json(['sucess' => true, 'message' => 'Fatura gerada com sucesso.', 'data' =>  FaturaResource::make($fatura)], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(UpdateOrDeleteFaturaRequest $request)
    {
        $fatura = Faturas::find($request->id);

        if (empty($fatura)) {
            return response()->json(['sucess' => false, 'message' => 'Fatura não encontrada.', 'data' => []], Response::HTTP_NO_CONTENT);
        }

        return response()->json(['sucess' => true, 'message' => 'Fatura consultada com sucesso.', 'data' =>  FaturaResource::make($fatura)], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrDeleteFaturaRequest $request)
    {
        $fatura = Faturas::find($request->id);

        if (empty($fatura)) {
            return response()->json(['sucess' => false, 'message' => 'Fatura não encontrada.', 'data' => []],  Response::HTTP_NO_CONTENT);
        }

        $fatura->cadastro_id    = isset($request->cadastro_id) ? $request->cadastro_id :  $fatura->cadastro_id;
        $fatura->assinatura_id  = isset($request->assinatura_id) ? $request->assinatura_id :  $fatura->assinatura_id;
        $fatura->descricao      = isset($request->descricao) ? $request->descricao : $fatura->descricao;
        $fatura->vencimento     = isset($request->vencimento) ? $request->vencimento : $fatura->vencimento;
        $fatura->valor          = isset($request->valor) ? $request->valor : $fatura->valor;
        $fatura->save();

        return response()->json(['sucess' => true, 'message' => 'Fatura atualizada com sucesso.', 'data' =>  FaturaResource::make($fatura)], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UpdateOrDeleteFaturaRequest $request)
    {
        $fatura = Faturas::find($request->id);

        if (empty($fatura)) {
            return response()->json(['sucess' => false, 'message' => 'Fatura não encontrada.', 'data' => []], Response::HTTP_NO_CONTENT);
        }

        $fatura->delete();

        return response()->json(['sucess' => true, 'message' => 'Fatura deletada com sucesso.', 'data' => []], Response::HTTP_OK);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\Assinatura\CreateAssinaturaRequest;
use App\Http\Requests\Assinatura\UpdateOrDeleteAssinaturaRequest;
use App\Http\Resources\AssinaturaResource;
use App\Models\Assinaturas;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Throwable;

class AssinaturasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AssinaturaResource::collection(Assinaturas::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAssinaturaRequest $request)
    {
        try {

            DB::beginTransaction();

            $assinatura = Assinaturas::create([
                'cadastro_id'           => $request->cadastro_id,
                'descricao'             => $request->descricao,
                'valor'                 => $request->valor,
                'dia_fechamento_fatura' => $request->dia_fechamento_fatura
            ]);

            DB::commit();
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(['data' => ['error' =>  'Erro ao inserir o assinatura: ' . $th->getMessage()]]);
        }

        return response()->json(['sucess' => true, 'message' => 'Assinatura inserida com sucesso.', 'data' =>  AssinaturaResource::make($assinatura)], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(UpdateOrDeleteAssinaturaRequest $request)
    {
        return AssinaturaResource::make(Assinaturas::find($request->id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrDeleteAssinaturaRequest $request)
    {
        $assinatura = Assinaturas::find($request->id);

        if (empty($assinatura)) {
            return response()->json(['sucess' => false, 'message' => 'Assinatura não encontrada.', 'data' => []],  Response::HTTP_NO_CONTENT);
        }

        $assinatura->cadastro_id            = isset($request->cadastro_id) ? $request->cadastro_id :  $assinatura->cadastro_id;
        $assinatura->descricao              = isset($request->descricao) ? $request->descricao : $assinatura->descricao;
        $assinatura->valor                  = isset($request->valor) ? $request->valor : $assinatura->valor;
        $assinatura->dia_fechamento_fatura  = isset($request->dia_fechamento_fatura) ? $request->dia_fechamento_fatura : $assinatura->dia_fechamento_fatura;
        $assinatura->ativo                  = isset($request->ativo) ? $request->ativo : $assinatura->ativo;
        $assinatura->save();

        return response()->json(['sucess' => true, 'message' => 'Assinatura atualizada com sucesso.', 'data' =>  AssinaturaResource::make($assinatura)], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UpdateOrDeleteAssinaturaRequest $request)
    {
        $assinatura = Assinaturas::find($request->id);

        if (empty($assinatura)) {
            return response()->json(['sucess' => false, 'message' => 'Assinatura não encontrada.', 'data' => []], Response::HTTP_NO_CONTENT);
        }

        $assinatura->ativo = false;
        $assinatura->save();

        return response()->json(['sucess' => true, 'message' => 'Assinatura deletada com sucesso.', 'data' =>  AssinaturaResource::make($assinatura)], Response::HTTP_OK);
    }
}

<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignatureRequest;
use App\Models\Invoice;
use App\Models\Signature;

class SignatureController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/signature",
     *     summary="Exibe uma lista dos recursos de assinatura.",
     *     tags={"Signatures"},
     *     @OA\Response(
     *         response=200,
     *         description="Retorna a lista de assinaturas com sucesso."
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Retorna um erro se ocorrer um problema durante a busca das assinaturas."
     *     )
     * )
     */
    public function index()
    {
        try {

            return response_api(Signature::with("cadastre")->get(), true, '');

        } catch (\Throwable $th) {
            
            return response_api([], false, $th->getMessage(), 400);

        }
    }

    /**
     * @OA\Post(
     *     path="/api/signature",
     *     summary="Armazena um novo recurso de assinatura.",
     *     tags={"Signatures"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SignatureRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna os dados da nova assinatura criada com sucesso."
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Retorna um erro se ocorrer um problema durante a criação da assinatura."
     *     )
     * )
     */
    public function store(SignatureRequest $request)
    {
        try {
           
            $signature = Signature::create($request->all());
            return response_api($signature, true, '');

        } catch (\Throwable $th) {
            
            return response_api([], false, $th->getMessage(), 400);

        }
    }

    /**
     * @OA\Get(
     *     path="/api/signature/{id}",
     *     summary="Exibe o recurso de assinatura especificado.",
     *     tags={"Signatures"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da assinatura a ser recuperada",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna os detalhes da assinatura encontrada com sucesso."
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Retorna um erro se a assinatura não for encontrada."
     *     )
     * )
     */
    public function show(string $id)
    {
        try {
           
            $signature = Signature::with("cadastre")->find($id);

            if (!$signature) {
                return response_api([], false, 'not found', 400);
            }

            return response_api($signature, true, '');

        } catch (\Throwable $th) {
            
            return response_api([], false, $th->getMessage(), 400);

        }
    }

    /**
     * @OA\Put(
     *     path="/api/signature/{id}",
     *     summary="Atualiza o recurso de assinatura especificado.",
     *     tags={"Signatures"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da assinatura a ser atualizada",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SignatureRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna os detalhes da assinatura atualizada com sucesso."
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Retorna um erro se a assinatura não for encontrada."
     *     )
     * )
     */
    public function update(SignatureRequest $request, string $id)
    {
        try {
           
            $signature = Signature::find($id);

            if (!$signature) {
                return response_api([], false, 'not found', 400);
            }

            $signature->update($request->all());

            return response_api($signature, true, '');

        } catch (\Throwable $th) {
            
            return response_api([], false, $th->getMessage(), 400);

        }
    }


    /**
     * @OA\Delete(
     *     path="/api/signature/{id}",
     *     summary="Exclui o recurso de assinatura especificado.",
     *     tags={"Signatures"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da assinatura a ser excluída",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna uma mensagem de sucesso após a exclusão."
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Retorna um erro se a assinatura não for encontrada."
     *     )
     * )
     */
    public function destroy(string $id)
    {
        try {
           
            $signature = Signature::find($id);

            if (!$signature) {
                return response_api([], false, 'not found', 400);
            }

            $signature->delete();

            return response_api([], true, '');

        } catch (\Throwable $th) {
            
            return response_api([], false, $th->getMessage(), 400);

        }
    }

    /**
     * @OA\Get(
     *     path="/api/verification_of_signatures",
     *     summary="Função para gerar as faturas.",
     *     tags={"Signatures"},
     *     @OA\Response(
     *         response=200,
     *         description="Função para gerar as faturas."
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Retorna um erro se ocorrer um problema durante a busca das assinaturas."
     *     )
     * )
     */
    public function verificationOfSignatures()
    {
        //Pega todas as assinaturas
        $signatures = Signature::all();
        
        foreach ($signatures as $signature) {

            $dataEspecifica = $signature->created_at; // Sua data específica fornecida
            $timestamp = strtotime($dataEspecifica);
            $mesAtual = date('m');// Obtenha o mês atual
            $dataNova = date('Y-' . $mesAtual . '-d', $timestamp);// Atualize o mês na data antiga
            $dataFormatada = date('Y-m-d', strtotime('+1 month -10 days', strtotime($dataNova)));//data com 10 dias para a proxima fatura
            $dataAtual = date('Y-m-d');

            //Verifica se a data atual é maior ou igual a data da proxima fatura
            if ( strtotime($dataAtual) >= strtotime($dataFormatada) ) {

                //Proximo vencimento
                $dataFormatada = date('Y-m-d', strtotime('+1 month', strtotime($dataNova)));//data com 10 dias para a proxima fatura

                //Se for maior, verifica se ja foi criada a proxima para não gerar novamente
                $existNextInvoice = Invoice::where("expiration", $dataFormatada)->first();

                //Se não existir ainda ele será criado
                if (!$existNextInvoice) {
                    Invoice::create([
                        'cadastre_id'=>$signature->cadastre_id, 
                        'signature_id'=>$signature->id, 
                        'describe'=>"Recorrência", 
                        'value'=>$signature->value, 
                        'expiration'=>$dataFormatada
                    ]);
                }


            }

        }

    }

}

<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/invoice",
     *     summary="Exibe uma lista dos recursos de faturas.",
     *     tags={"Invoices"},
     *     @OA\Response(
     *         response=200,
     *         description="Retorna a lista de faturas com sucesso."
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Retorna um erro se ocorrer um problema durante a busca das faturas."
     *     )
     * )
     */
    public function index()
    {
        try {

            return response_api(Invoice::with("signature", "cadastre")->get(), true, '');

        } catch (\Throwable $th) {
            
            return response_api([], false, $th->getMessage(), 400);

        }
    }

    /**
     * @OA\Post(
     *     path="/api/invoice",
     *     summary="Armazena um novo recurso de fatura.",
     *     tags={"Invoices"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/InvoiceRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna os dados da nova fatura criada com sucesso."
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Retorna um erro se ocorrer um problema durante a criação da fatura."
     *     )
     * )
     */
    public function store(InvoiceRequest $request)
    {
        try {
           
            $invoice = Invoice::create($request->all());
            return response_api($invoice, true, '');

        } catch (\Throwable $th) {
            
            return response_api([], false, $th->getMessage(), 400);

        }
    }

    /**
     * @OA\Get(
     *     path="/api/invoice/{id}",
     *     summary="Exibe o recurso de fatura especificado.",
     *     tags={"Invoices"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da fatura a ser recuperada",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna os detalhes da fatura encontrada com sucesso."
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Retorna um erro se a fatura não for encontrada."
     *     )
     * )
     */
    public function show(string $id)
    {
        try {
           
            $invoice = Invoice::with("signature", "cadastre")->find($id);

            if (!$invoice) {
                return response_api([], false, 'not found', 400);
            }

            return response_api($invoice, true, '');

        } catch (\Throwable $th) {
            
            return response_api([], false, $th->getMessage(), 400);

        }
    }

    /**
     * @OA\Put(
     *     path="/api/invoice/{id}",
     *     summary="Atualiza o recurso de fatura especificado.",
     *     tags={"Invoices"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da fatura a ser atualizada",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/InvoiceRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna os detalhes da fatura atualizada com sucesso."
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Retorna um erro se a fatura não for encontrada."
     *     )
     * )
     */
    public function update(InvoiceRequest $request, string $id)
    {
        try {
           
            $invoice = Invoice::find($id);

            if (!$invoice) {
                return response_api([], false, 'not found', 400);
            }

            $invoice->update($request->all());

            return response_api($invoice, true, '');

        } catch (\Throwable $th) {
            
            return response_api([], false, $th->getMessage(), 400);

        }
    }

    /**
     * @OA\Delete(
     *     path="/api/invoice/{id}",
     *     summary="Exclui o recurso de fatura especificado.",
     *     tags={"Invoices"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da fatura a ser excluída",
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
     *         description="Retorna um erro se a fatura não for encontrada."
     *     )
     * )
     */
    public function destroy(Request $request, string $id)
    {
        try {
           
            $invoice = Invoice::find($id);

            if (!$invoice) {
                return response_api([], false, 'not found', 400);
            }

            $invoice->delete();

            return response_api([], true, '');

        } catch (\Throwable $th) {
            
            return response_api([], false, $th->getMessage(), 400);

        }
    }
}

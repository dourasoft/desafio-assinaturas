<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\Fatura\FaturaRepository;
use Illuminate\Http\Request;

class FaturaController extends Controller
{
    protected $faturaRepository;

    public function __construct(FaturaRepository $faturaRepository)
    {
        $this->faturaRepository = $faturaRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faturas = $this->faturaRepository->getAll();

        return response()->json($faturas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $FaturaData = $request->validate([
            'id_tab_Cadastros' => 'required|integer',
            'id_tab_Assinaturas' => 'required|integer',
            'status_pago' => 'nullable|boolean',
            'descricao' => 'nullable|string',
            'vencimento' => 'required|date',
            'valor' => 'required|numeric',
        ]);

        // Criação do fatura
        $fatura = $this->faturaRepository->create($FaturaData);

        return response()->json($fatura, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $fatura = $this->faturaRepository->getById($id);

        if (!$fatura) {
            return response()->json(['message' => 'Fatura não encontrado'], 404);
        }

        return response()->json($fatura);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validação dos dados recebidos
        $FaturaData = $request->validate([
            'id_tab_Cadastros' => 'required|integer',
            'id_tab_Assinaturas' => 'required|integer',
            'status_pago' => 'nullable|boolean',
            'descricao' => 'nullable|string',
            'vencimento' => 'required|date',
            'valor' => 'required|numeric',
        ]);

        // Atualização do fatura
        $fatura = $this->faturaRepository->update($id, $FaturaData);

        return response()->json($fatura);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->faturaRepository->delete($id);

        return response()->json(['message' => 'Fatura excluído com sucesso']);
    }
}

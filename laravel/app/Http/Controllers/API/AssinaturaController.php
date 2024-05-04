<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\Assinatura\AssinaturaRepository;
use Illuminate\Http\Request;

class AssinaturaController extends Controller
{
    protected $assinaturaRepository;

    public function __construct(AssinaturaRepository $assinaturaRepository)
    {
        $this->assinaturaRepository = $assinaturaRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assinaturas = $this->assinaturaRepository->getAll();

        return response()->json($assinaturas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $AssinaturaData = $request->validate([
            'id_tab_Cadastros' => 'required|integer',
            'descricao' => 'nullable|string',
            'vencimento' => 'required|date',
            'valor' => 'required|numeric',
        ]);

        // Criação do assinatura
        $assinatura = $this->assinaturaRepository->create($AssinaturaData);

        return response()->json($assinatura, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $assinatura = $this->assinaturaRepository->getById($id);

        if (!$assinatura) {
            return response()->json(['message' => 'Assinatura não encontrado'], 404);
        }

        return response()->json($assinatura);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validação dos dados recebidos
        $AssinaturaData = $request->validate([
            'id_tab_Cadastros' => 'required|integer',
            'descricao' => 'nullable|string',
            'vencimento' => 'required|date',
            'valor' => 'required|numeric',
        ]);

        // Atualização do assinatura
        $assinatura = $this->assinaturaRepository->update($id, $AssinaturaData);

        return response()->json($assinatura);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->assinaturaRepository->delete($id);

        return response()->json(['message' => 'Assinatura excluído com sucesso']);
    }
}

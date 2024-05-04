<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\Cadastro\CadastroRepository;
use Illuminate\Http\Request;

class CadastroController extends Controller
{
    protected $cadastroRepository;

    public function __construct(CadastroRepository $cadastroRepository)
    {
        $this->cadastroRepository = $cadastroRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cadastros = $this->cadastroRepository->getAll();

        return response()->json($cadastros);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $CadastroData = $request->validate([
            'codigo' => 'required|string',
            'nome' => 'required|string',
            'email' => 'required|email',
            'telefone' => 'required|string',
        ]);

        // Criação do cadastro
        $cadastro = $this->cadastroRepository->create($CadastroData);

        return response()->json($cadastro, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $cadastro = $this->cadastroRepository->getById($id);

        if (!$cadastro) {
            return response()->json(['message' => 'Cadastro não encontrado'], 404);
        }

        return response()->json($cadastro);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validação dos dados recebidos
        $CadastroData = $request->validate([
            'codigo' => 'required|string',
            'nome' => 'required|string',
            'email' => 'required|email',
            'telefone' => 'required|string',
        ]);

        // Atualização do cadastro
        $cadastro = $this->cadastroRepository->update($id, $CadastroData);

        return response()->json($cadastro);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->cadastroRepository->delete($id);

        return response()->json(['message' => 'Cadastro excluído com sucesso']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Cadastro;
use App\Repositories\CadastroRepository;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $inventory = $this->cadastroRepository->getById($id);

        if (!$cadastro) {
            return response()->json(['message' => 'Cadastro não encontrado'], 404);
        }

        return response()->json($cadastro);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cadastro $cadastro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cadastro $cadastro)
    {
        //
    }
}

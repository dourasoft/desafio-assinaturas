<?php

namespace App\Repositories\Cadastro;

use App\Models\Cadastro;

class CadastroRepository
{
    public function getById($id)
    {
        return Cadastro::findOrFail($id);
    }

    public function getAll()
    {
        return Cadastro::all();
    }

    public function create($data)
    {
        return Cadastro::create($data);
    }

    public function update($id, $data)
    {
        $cadastro = Cadastro::findOrFail($id);
        $cadastro->update($data);
        return $cadastro;
    }

    public function delete($id)
    {
        $cadastro = Cadastro::findOrFail($id);
        $cadastro->delete();
    }
}

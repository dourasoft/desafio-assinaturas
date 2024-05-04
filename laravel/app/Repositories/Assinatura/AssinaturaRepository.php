<?php

namespace App\Repositories\Assinatura;

use App\Models\Assinatura;

class AssinaturaRepository
{
    public function getById($id)
    {
        return Assinatura::findOrFail($id);
    }

    public function getAll()
    {
        return Assinatura::all();
    }

    public function create($data)
    {
        return Assinatura::create($data);
    }

    public function update($id, $data)
    {
        $assinatura = Assinatura::findOrFail($id);
        $assinatura->update($data);
        return $assinatura;
    }

    public function delete($id)
    {
        $assinatura = Assinatura::findOrFail($id);
        $assinatura->delete();
    }
}

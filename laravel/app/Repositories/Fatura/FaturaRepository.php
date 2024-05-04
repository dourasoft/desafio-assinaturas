<?php

namespace App\Repositories\Fatura;

use App\Models\Fatura;

class FaturaRepository
{
    public function getById($id)
    {
        return Fatura::findOrFail($id);
    }

    public function getAll()
    {
        return Fatura::all();
    }

    public function create($data)
    {
        return Fatura::create($data);
    }

    public function update($id, $data)
    {
        $fatura = Fatura::findOrFail($id);
        $fatura->update($data);
        return $fatura;
    }

    public function delete($id)
    {
        $fatura = Fatura::findOrFail($id);
        $fatura->delete();
    }
}

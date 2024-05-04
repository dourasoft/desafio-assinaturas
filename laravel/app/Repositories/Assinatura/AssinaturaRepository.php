<?php

namespace App\Repositories\Assinatura;

use App\Models\Assinatura;
use Carbon\Carbon;

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

    public function verificarAssinaturas()
    {
        $assinaturas = Assinatura::whereDate('vencimento', '>=', now())
                                    ->whereDate('vencimento', '<=', now()->addDays(10))
                                    ->where('fatura_gerada', 0)
                                    ->get();

        foreach ($assinaturas as $assinatura) {
            $assinatura->fatura_gerada = 1;
            $assinatura->save();
        }
        return $assinaturas;
    }
}

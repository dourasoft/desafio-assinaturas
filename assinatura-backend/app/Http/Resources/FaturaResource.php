<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FaturaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'cadastro_id'   => $this->cadastro_id,
            'assinatura_id' => $this->assinatura_id,
            'descricao'     => $this->descricao,
            'vencimento'    => $this->vencimento,
            'valor'         => $this->valor
        ];
    }
}

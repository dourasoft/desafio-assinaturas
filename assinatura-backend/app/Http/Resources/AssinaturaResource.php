<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssinaturaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->id,
            'cadastro_id'           => $this->cadastro_id,
            'descricao'             => $this->descricao,
            'valor'                 => $this->valor,
            'dia_fechamento_fatura' => $this->dia_fechamento_fatura,
            'ativo'                 => $this->ativo
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CadastroResource extends JsonResource
{
    /**
     * Transform the resource into an array. 
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'codigo'    => $this->codigo,
            'nome'      => $this->nome,
            'email'     => $this->email,
            'telefone'  => $this->telefone,
            'ativo'     => $this->ativo
        ];
    }
}

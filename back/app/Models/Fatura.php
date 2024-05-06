<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Assinaturas;

class Fatura extends Model
{
    use HasFactory;

    protected $fillable = ['valor', 'data_vencimento', 'data_pagamento', 'assinatura_id', 'status'];

    public function assinatura()
    {
        return $this->belongsTo(Assinaturas::class);
    }
    public function getDataVencimentoAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }
    
    public function getDataPagamentoAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }
    
}

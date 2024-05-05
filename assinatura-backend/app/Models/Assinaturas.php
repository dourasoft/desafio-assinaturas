<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assinaturas extends Model
{
    use HasFactory;

    protected $fillable = [
        'cadastro_id',
        'descricao',
        'valor',
        'dia_fechamento_fatura',
        'ativo'
    ];
}

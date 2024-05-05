<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faturas extends Model
{
    use HasFactory;

    protected $fillable = [
        'cadastro_id',
        'assinatura_id',
        'descricao',
        'vencimento',
        'valor'
    ];
}

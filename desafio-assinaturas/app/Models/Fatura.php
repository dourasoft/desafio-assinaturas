<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fatura extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cadastro_id',
        'assinatura_id',
        'descricao',
        'data_vencimento',
        'valor'
    ];

    public function cadastro()
    {
        return $this->belongsTo(Cadastro::class);
    }

    public function assinatura()
    {
        return $this->belongsTo(Assinatura::class);
    }
}

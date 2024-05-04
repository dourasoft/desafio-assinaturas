<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assinatura extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cadastro_id',
        'descricao',
        'valor',
        'flag_assinado',
        'data_vencimento'
    ];

    public function cadastro()
    {
        return $this->belongsTo(Cadastro::class);
    }

    public function fatura()
    {
        return $this->hasOne(Fatura::class, 'assinatura_id');
    }
}

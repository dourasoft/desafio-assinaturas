<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cadastro extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'codigo',
        'email',
        'telefone'
    ];

    public function assinatura()
    {
        return $this->hasOne(Assinatura::class, 'cadastro_id');
    }

    public function fatura()
    {
        return $this->hasOne(Fatura::class, 'cadastro_id');
    }
}

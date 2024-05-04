<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cadastro extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo', 'nome', 'email', 'telefone',
    ];

    protected $primaryKey = 'id'; // Definindo a chave primária explicitamente

    public $timestamps = true; // Habilita a funcionalidade de timestamps

    const CREATED_AT = 'created_at'; // Especifica o nome do campo created_at
    const UPDATED_AT = 'updated_at'; // Especifica o nome do campo updated_at
}

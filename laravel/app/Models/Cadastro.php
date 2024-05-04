<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cadastro extends Model
{
    use HasFactory;

    protected $fillable = [
        'Codigo', 'Nome', 'Email', 'Telefone',
    ];

    protected $primaryKey = 'id'; // Definindo a chave primária explicitamente
}

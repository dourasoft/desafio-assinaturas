<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fatura extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_tab_Cadastros',
        'id_tab_Assinaturas',
        'status_pago',
        'descricao',
        'vencimento',
        'valor',
    ];

    protected $primaryKey = 'id'; // Definindo a chave primária explicitamente

    public $timestamps = true; // Habilita a funcionalidade de timestamps

    const CREATED_AT = 'created_at'; // Especifica o nome do campo created_at
    const UPDATED_AT = 'updated_at'; // Especifica o nome do campo updated_at

    protected $casts = [
        'status_pago' => 'boolean',
        'vencimento' => 'datetime',
    ];

    public function cadastro()
    {
        return $this->belongsTo(Cadastro::class, 'id_tab_Cadastros', 'id');
    }

    public function assinatura()
    {
        return $this->belongsTo(Assinatura::class, 'id_tab_Assinaturas', 'id');
    }
}

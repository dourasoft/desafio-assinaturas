<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assinaturas extends Model
{
    use HasFactory;

    protected $fillable = ['descricao', 'valor', 'dia_vencimento', 'user_id', 'ativo'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function faturas()
    {
        return $this->hasMany(Fatura::class, 'assinatura_id');
    }

}

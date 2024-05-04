<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    #Tabela de Faturas
    use HasFactory;

    protected $fillable = [
        'cadastre_id', 'signature_id', 'describe', 'value', 'expiration'
    ];

    
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
    ];

    public function cadastre()
    {
        return $this->belongsTo(Cadastre::class, 'cadastre_id');
    }

    public function signature()
    {
        return $this->belongsTo(Signature::class, 'signature_id');
    }
}

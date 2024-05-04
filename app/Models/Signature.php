<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{

    #Tabela de assinaturas
    use HasFactory;

    protected $fillable = [
        'cadastre_id', 'describe', 'value'
    ];

    
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
    ];

    public function cadastre()
    {
        return $this->belongsTo(Cadastre::class, 'cadastre_id');
    }
}

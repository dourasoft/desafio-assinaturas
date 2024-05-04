<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cadastre extends Model
{

    #Tabela de Cadastros
    use HasFactory;

    protected $fillable = [
        'cod', 'name', 'email', 'phone'
    ];


    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
    ];

    public function signature()
    {
        return $this->hasMany(Signature::class, 'cadastre_id', 'id');
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class, 'invoice_id', 'id');
    }
}

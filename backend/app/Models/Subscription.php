<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['registration_id', 'description', 'value', 'is_active', 'due_day'];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
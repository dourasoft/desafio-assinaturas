<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'subscription_id',
        'description',
        'due_date',
        'value',
        'status',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
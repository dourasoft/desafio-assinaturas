<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['register_id', 'subscription_id', 'description', 'due_date', 'value'];

    function register(): BelongsTo
    {
        return $this->belongsTo(Register::class);
    }

    function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }
}

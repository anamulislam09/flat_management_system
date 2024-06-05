<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'month',
        'year',
        'client_id',
        'auth_id',
        'invoice_id',
        'user_id',
        'user_name',
        'charge',
        'amount',
        'due',
        'paid',
        'status',
        'date'
    ];
}

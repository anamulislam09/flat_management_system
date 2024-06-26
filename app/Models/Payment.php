<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'invoice_id',
        'payment_amount',
        'paid',
        'due',
        'date',
        'month',
        'year',
        'valid'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OthersIncome extends Model
{
    use HasFactory;

    protected $fillable = [
        'month',
        'year',
        'date',
        'client_id',
        'auth_id',
        'invoice_id',
        'income_info',
        'amount',
    ];
}

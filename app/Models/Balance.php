<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'auth_id',
        'year',
        'month',
        'total_income',
        'total_expense',
        'amount',
        'flag',
        'date'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = [
        'cat_id',
        'year',
        'month',
        'amount',
        'client_id',
        'date',
        'auth_id'
    ];
}



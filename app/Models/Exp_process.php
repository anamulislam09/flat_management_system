<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exp_process extends Model
{
    use HasFactory;
    protected $fillable = [
        'year',
        'month',
        'total',
        'client_id',
        'auth_id',
    ];
}

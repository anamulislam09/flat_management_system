<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpeningBalance extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'auth_id',
        'year',
        'month',
        'profit',
        'loss',
        'entry_datetime',
        'flag',
    ];
}

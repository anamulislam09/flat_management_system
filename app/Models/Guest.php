<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'name',
        'phone',
        'image',
        'address',
        'create_date',
        'create_by',
    ];
}

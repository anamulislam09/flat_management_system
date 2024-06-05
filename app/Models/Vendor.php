<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'client_id',
        'auth_id',
        'name',
        'phone',
        'address',
    ];
}

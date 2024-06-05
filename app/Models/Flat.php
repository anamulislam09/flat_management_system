<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flat extends Model
{
    use HasFactory;
    protected $fillable = [
        'flat_id',
        'client_id',
        'flat_name',
        'sequence',
        'floor_no',
        'charge',
        'amount',
        'status',
        'create_date',
        'create_month',
        'create_year',
    ];

}

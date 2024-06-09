<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'flat_id',
        'name',
        'phone',
        'image',
        'address',
        'purpose',
        'entry_date',
        'exit_date',
        'create_by'
    ];
}

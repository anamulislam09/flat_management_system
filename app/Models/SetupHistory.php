<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetupHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'auth_id',
        'exp_id',
        'vendor_id',
        'start_date',
        'interval_days',
        'end_date',
    ];
}

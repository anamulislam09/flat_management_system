<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestHistory extends Model
{
    use HasFactory;    
    protected $guarded = ['id'];
    // protected $fillable = [
    //     'client_id',
    //     'client_id',
    //     'flat_id',
    //     'purpose',
    //     'entry_date',
    //     'exit_date',
    //     'create_by'
    // ];
}

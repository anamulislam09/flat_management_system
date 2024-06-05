<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $guard = 'admin';
    protected $fillable = [
        'id',
        'name',
        'phone',
        'address',
        'nid_no',
        'image',
        'email',
        'password',
        'remember_token',
        'email_verified_at',
        'status',
        'role',
    ];
}

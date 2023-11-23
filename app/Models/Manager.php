<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Manager extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'email',
        'mobile',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}

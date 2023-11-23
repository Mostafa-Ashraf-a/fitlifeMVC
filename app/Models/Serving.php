<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serving extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'plan_id',
        'plan_status',
        'status',
        'starches',
        'fruits',
        'vegetables',
        'meats',
        'dairy',
        'oils',
    ];
}

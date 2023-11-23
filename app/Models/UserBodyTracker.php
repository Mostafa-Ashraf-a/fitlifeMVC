<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBodyTracker extends Model
{
    use HasFactory, Filterable;
    protected $fillable = ['user_id','weight','water','sleep','date'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutType extends Model
{
    use HasFactory;
    protected $fillable = [
      'value','repetition'
    ];
}

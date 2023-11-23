<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayExerciseType extends Model
{
    use HasFactory;
    protected $fillable = [
        'workout_id','day','type'
    ];
}

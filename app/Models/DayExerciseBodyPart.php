<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayExerciseBodyPart extends Model
{
    use HasFactory;
    protected $fillable = [
        'workout_id','body_part_id','day'
    ];
}

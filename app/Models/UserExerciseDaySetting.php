<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExerciseDaySetting extends Model
{
    use HasFactory;
    protected $table = 'user_exercise_day_settings';
    protected $fillable = [
        'user_id','exercise_id','day','rest','sets','reps'
    ];
}

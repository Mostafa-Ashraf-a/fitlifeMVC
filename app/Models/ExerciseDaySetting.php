<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseDaySetting extends Model
{
    use HasFactory;
    protected $table = 'exercise_day_settings';
    protected $fillable = [
      'user_id','day','rest','sets','reps'
    ];
}

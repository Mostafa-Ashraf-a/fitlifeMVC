<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExerciseProgramSuggestion extends Model
{
    use HasFactory;
    protected $table = 'user_exercise_program_suggestions';
    protected $fillable = [
        'user_id',
        'day_id',
        'body_part_id',
        'exercise_id',
        'exercise_type_id',
        'start_at',
        'end_at',
        'program_duration',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayFour extends Model
{
    use HasFactory;
    protected $fillable = [
        'exercise_id','workout_id','exercise_type'
    ];
    public function exercises()
    {
        return $this->belongsTo(Exercise::class,'exercise_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseBodyPart extends Model
{
    use HasFactory;
    protected $fillable = [
      'exercise_id','body_part_id'
    ];
    public function bodyParts(){
        return $this->hasMany(BodyPart::class);
    }
    public function exercises(){
        return $this->hasMany(Exercise::class,'id','exercise_id');
    }
}

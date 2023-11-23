<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseTranslation extends Model
{
    use HasFactory;
    protected $fillable = ['title','tips','instructions'];
    public $timestamps = false;
}

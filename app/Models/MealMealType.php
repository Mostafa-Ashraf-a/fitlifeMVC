<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealMealType extends Model
{
    use HasFactory;
    protected $fillable = [
      'meal_id','meal_type_id'
    ];
}

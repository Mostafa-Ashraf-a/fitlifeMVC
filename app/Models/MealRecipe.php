<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealRecipe extends Model
{
    use HasFactory;
    protected $table = 'meal_recipes';
    protected $fillable = [
        'meal_id',
        'recipe_id',
        'meal_type_id'
    ];
}

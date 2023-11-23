<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanMealTypesMeals extends Model
{
    use HasFactory;
    protected $table = 'plan_meal_types_meals';
    protected $fillable = [
         'meal_plan_id',
         'meal_type_id',
         'meal_id',
    ];

    public function mealTypes()
    {
        return $this->belongsToMany(MealType::class,'plan_meal_types_meals','meal_plan_id','meal_type_id');
    }
}

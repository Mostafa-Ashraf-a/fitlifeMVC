<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class Meal extends Model implements TranslatableContract
{
    use HasFactory, Translatable;
    public $translatedAttributes = ['title'];
    protected $fillable = ['is_default','meal_type_id'];

    // v2

    public function foodExchanges()
    {
        return $this->belongsToMany(FoodExchange::class,'user_meals_plans','meal_id','food_exchange_id')
            ->where('user_id',auth()->guard('user-api')->user()->id)
            ->where('status',2)
            ->groupBy('food_exchange_id')
            ->withPivot('quantity');
    }
    public function underConstructionFoodExchanges()
    {
        return $this->belongsToMany(FoodExchange::class,'user_meals_plans','meal_id','food_exchange_id')
            ->where('user_id',auth()->guard('user-api')->user()->id)
            ->where('status',1)
            ->withPivot('quantity');
    }

    public function historyFoodExchanges()
    {
        return $this->belongsToMany(FoodExchange::class,'user_meals_plans','meal_id','food_exchange_id')
            ->where('user_id',auth()->guard('user-api')->user()->id)
            ->where('status',3)
            ->withPivot('quantity');
    }

    // Suggested Meal Plan

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class,'meal_recipes','meal_id','recipe_id')
            ->withPivot('meal_type_id')
            ->groupBy(['meal_id','recipe_id']);
    }
    public function mealType()
    {
        return $this->belongsTo(MealType::class,'meal_type_id');
    }

}

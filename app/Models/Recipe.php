<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Facades\Storage;

class Recipe extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['title','instructions','other_info'];
    protected $fillable = ['image'];

    // v1
    public function mealTypes(){
        return $this->belongsToMany(MealType::class,'recipe_meal_types');
    }
    public function meals(){
        return $this->belongsToMany(Meal::class,'meal_recipes');
    }
    // end v1

    public function foodExchanges()
    {
        return $this->belongsToMany(FoodExchange::class, 'recipe_food_exchanges','recipe_id','food_exchange_id');
    }
}

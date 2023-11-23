<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMealTypeFoodExchange extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','meal_type_id','food_exchange_id'];
    public function mealTypes()
    {
        return $this->belongsTo(MealType::class,'meal_type_id');
    }
    public function foodExchanges()
    {
        return $this->belongsTo(FoodExchange::class,'food_exchange_id');
    }
}

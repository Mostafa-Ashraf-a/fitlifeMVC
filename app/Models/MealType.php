<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class MealType extends Model implements TranslatableContract
{
    use HasFactory, Translatable;
    public $translatedAttributes = ['title'];
    protected $fillable = ['status','image'];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class,'recipe_meal_types');
    }

    public function foodExchanges()
    {
        return $this->belongsToMany(FoodExchange::class,'user_meal_type_food_exchanges','meal_type_id','food_exchange_id')
            ->where('user_id',auth()->guard('user-api')->user()->id)
            ->where('date','=',request()->query('date'))
            ->withPivot('date');
    }

    // Suggested Meal Plan
    public function mealTypeMeal()
    {
        #TODO check it again
        return  $this->belongsToMany(Meal::class,'plan_meal_types_meals','meal_type_id','meal_id')
            ->withPivot('meal_plan_id','meal_type_id','meal_id')
            ->groupBy('meal_type_id','meal_id');
    }

    public function suggestedRecipes()
    {
        return $this->belongsToMany(Recipe::class, 'user_suggested_plan','meal_type_id','recipe_id')
            ->where('user_id', auth()->guard('user-api')->user()->id)
            ->withPivot('plan_id','duration','status','recipe_id')
//            ->where('status',1)
            ->where('duration',2)
            ->where('day_number','=',\request()->query('day_number'))
            ->withPivot('plan_id','duration','status','meal_type_id','recipe_id')
            ->groupBy('meal_type_id','recipe_id')
            ->distinct();
    }
    public function historySuggestedRecipes()
    {
        $duration = (integer)\request()->query('duration');
        $dayNumber = (integer)\request()->query('day_number');
        return $this->belongsToMany(Recipe::class, 'user_suggested_plan','meal_type_id','recipe_id')
            ->where('user_id', auth()->guard('user-api')->user()->id)
            ->withPivot('plan_id','duration','status','recipe_id')
            ->where('duration', $duration)
            ->where('day_number',$dayNumber)
            ->withPivot('plan_id','duration','status','meal_type_id','recipe_id')
            ->groupBy('meal_type_id','recipe_id')
            ->distinct();
    }

    public function dailyRunningSuggestedRecipes()
    {
        $now = Carbon::now('Asia/Riyadh')->format('Y-m-d');
        return $this->belongsToMany(Recipe::class, 'user_suggested_plan','meal_type_id','recipe_id')
            ->where('user_id', auth()->guard('user-api')->user()->id)
            ->whereDate('start_date','<=',$now)
            ->whereDate('end_date','>=',$now)
            ->where('status',1)
            ->withPivot('plan_id','duration','status','meal_type_id','recipe_id')
            ->groupBy('meal_type_id','recipe_id')
            ->distinct();
    }
}

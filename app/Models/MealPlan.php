<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class MealPlan extends Model
{
    use HasFactory;
    protected $fillable = ['title','added_by','goal_id'];

    const  UNDER_CONSTRUCTION   = 1;
    const  IN_PROGRESS          = 2;
    const  ARCHIVED             = 3;

    public function meals()
    {
        return $this->belongsToMany(Meal::class,'user_meals_plans','plan_id','meal_id')
            ->where('user_id',auth()->guard('user-api')->user()->id)
            ->where('status',self::IN_PROGRESS)
            ->groupBy('meal_id');
    }

    public function goal() : BelongsTo
    {
        return $this->belongsTo(Goal::class, 'goal_id');
    }

    public function historyMeals()
    {
        return $this->belongsToMany(Meal::class,'user_meals_plans','plan_id','meal_id')
            ->where('user_id',auth()->guard('user-api')->user()->id)
            ->where('status',self::ARCHIVED)
            ->groupBy('meal_id');
    }

    // Suggested Meal Plan

    public function suggestedMealTypes()
    {
        return $this->belongsToMany(MealType::class, 'plan_meal_types_meals','meal_plan_id','meal_type_id')
            ->withPivot('meal_plan_id','meal_type_id','meal_id')
            ->groupBy('meal_plan_id','meal_type_id');
    }

    public function mealTypes()
    {
        return $this->belongsToMany(MealType::class, 'user_suggested_plan','plan_id','meal_type_id')
            ->where('user_id', auth()->guard('user-api')->user()->id)
//            ->where('status',1)
            ->where('duration', 2)
            ->where('day_number','=',\request()->query('day_number'))
            ->groupBy('meal_type_id')
            ->withPivot('duration','day_number','plan_id','cal','proteins','carbs','fats','recipe_id');
    }

    public function historyMealTypes()
    {
        $duration = (integer)\request()->query('duration');
        $dayNumber = (integer)\request()->query('day_number');

        return $this->belongsToMany(MealType::class, 'user_suggested_plan','plan_id','meal_type_id')
            ->where('user_id', auth()->guard('user-api')->user()->id)
            ->where('duration', $duration)
            ->where('day_number',$dayNumber)
            ->groupBy('meal_type_id')
            ->withPivot('duration','day_number','plan_id','cal','proteins','carbs','fats','recipe_id');
    }

    public function dailyRunningMealTypes()
    {
        $now = Carbon::now('Asia/Riyadh')->format('Y-m-d');
        return $this->belongsToMany(MealType::class, 'user_suggested_plan','plan_id','meal_type_id')
            ->where('user_id', auth()->guard('user-api')->user()->id)
            ->whereDate('start_date','<=',$now)
            ->whereDate('end_date','>=',$now)
            ->where('status',1)
            ->groupBy('meal_type_id')
            ->withPivot('duration','day_number','plan_id','cal','proteins','carbs','fats','recipe_id','status');

    }
}

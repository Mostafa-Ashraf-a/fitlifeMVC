<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserMealPlan extends Model
{
    use HasFactory;
    const HISTORY_PLAN                    = 3;
    const IN_PROGRESS_PLAN                = 2;
    protected $table = 'user_meals_plans';
    protected $fillable = [
      'meal_id',
      'user_id',
      'plan_id',
      'food_exchange_id',
      'quantity',
      'status',
      'type',
      'duration',
      'day_number',
      'week_number',
      'start_date',
      'end_date',
    ];

    public function historyPlans() : BelongsTo
    {
        return $this->belongsTo(MealPlan::class,'plan_id');
    }

    public function plan() : BelongsTo
    {
        return $this->belongsTo(MealPlan::class,'plan_id');
    }

    public function underConstructionMeals() : BelongsTo
    {
        return $this->belongsTo(Meal::class, 'meal_id');
    }

}

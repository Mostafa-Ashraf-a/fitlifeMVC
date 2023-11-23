<?php


namespace App\Services\Dashboard\Nutrition;


use App\Models\MealPlan;
use App\Models\PlanMealTypesMeals;
use Illuminate\Support\Facades\DB;

class MealPlanService
{
    public function store($request)
    {
        $mealPlan = $this->storeMealPlan($request);
        $this->storeOrUpdatePlanMealTypeMeals($request, $mealPlan);
    }

    public function storeMealPlan($request)
    {
        return MealPlan::create([
            'title'   => $request->title,
            'goal_id'   => $request->goal_id
        ]);
    }

    public function storeOrUpdatePlanMealTypeMeals($request, $mealPlan)
    {
        foreach ($request->meal_type_id as $key => $value)
        {
            $check = DB::table('plan_meal_types_meals')
                ->where('meal_plan_id', $mealPlan->id)
                ->where('meal_type_id', $value)
                ->where('meal_id', $request->meal_id[$key])
                ->first();
            if(!$check)
            {
                $mealPlan->suggestedMealTypes()->attach($value,['meal_id'=>$request->meal_id[$key]]);
            }
        }
    }

    public function update($request, $mealPlan)
    {
        foreach ($request->meal_type_id as $key => $value)
        {
            $check = DB::table('plan_meal_types_meals')
                ->where('meal_plan_id', $mealPlan->id)
                ->where('meal_type_id', $value)
                ->where('meal_id', $request->meal_id[$key])
                ->first();
            if(!$check)
            {
                $mealPlan->suggestedMealTypes()->attach($value,['meal_id'=>$request->meal_id[$key]]);
            }
        }
        $mealPlan->update([
           'title'     => $request->title,
           'goal_id'   => $request->goal_id,
        ]);
    }
}

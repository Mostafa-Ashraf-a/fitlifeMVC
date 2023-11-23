<?php

namespace App\Http\Requests\Dashboard\Nutrition\MealPlan;

use App\Models\MealPlan;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $mealPlan = MealPlan::findOrFail(\request('meal_plan_id'));
        if($mealPlan->added_by != 2){
            return [
                'title'            => 'required',
                'goal_id'          => 'required',
                'meal_type_id'     => 'required',
                'meal_id'          => 'required',
            ];
        }
        return [
            'title'            => 'required',
        ];
    }
}

<?php

namespace App\Http\Requests\API\User\Nutrition;

use Illuminate\Foundation\Http\FormRequest;

class SubmitPlanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'duration'                    => 'required|integer|in:1,2',     // 1=> daily, 2=>weekly plan
            'plan_id'                     => 'required|exists:App\Models\MealPlan,id',
            'day_number'                  => 'required|exists:App\Models\MealPlan,id',
            'recipes'                     => 'required|array',
            'recipes.*.recipe_id'         => 'required|integer|exists:App\Models\Recipe,id',
            'recipes.*.meal_type_id'      => 'required|integer|exists:App\Models\MealType,id',
        ];
    }
}

<?php

namespace App\Http\Requests\Dashboard\Nutrition\MealPlan;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'            => 'required',
            'goal_id'          => 'required',
            'meal_type_id'     => 'required',
            'meal_id'          => 'required',
        ];
    }
}

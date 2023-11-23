<?php

namespace App\Http\Requests\Dashboard\Nutrition;

use Illuminate\Foundation\Http\FormRequest;

class MealRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title_en'         => 'required',
            'title_ar'         => 'required',
            'meal_type_id'     => 'required',
            'recipe_id'        => 'required',
        ];
    }
}

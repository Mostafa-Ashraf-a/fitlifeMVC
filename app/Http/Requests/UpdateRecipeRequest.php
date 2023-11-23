<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecipeRequest extends FormRequest
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
            'title'             => 'required',
            'description'             => 'required',
            'directions'             => 'required',
            'category_id'             => 'required',
            'calories'             => 'required',
            'carbs'             => 'required',
            'protein'             => 'required',
            'fat'             => 'required',
            'servings'             => 'required',
            'total_time'             => 'required',
            'featured'             => 'required',
            'status'             => 'required',
            'ingredient_id'             => 'required',
            'image'             => 'sometimes|mimes:jpg,png,jpeg|max:5048',
        ];
    }
    public function messages()
    {
        return [

        ];
    }
}

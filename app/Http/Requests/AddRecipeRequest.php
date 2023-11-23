<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddRecipeRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title_en'                => 'required',
            'title_ar'                => 'required',
            'instruction_en'          => 'required',
            'instruction_ar'          => 'required',
            'other_info_en'           => 'sometimes',
            'other_info_ar'           => 'sometimes',
            'food_exchange_id'        => 'required',
            'image'                   => 'required|mimes:jpg,png,jpeg|max:5048',
        ];
    }
}

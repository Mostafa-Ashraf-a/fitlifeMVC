<?php

namespace App\Http\Requests\API\User\Nutrition;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'  => 'required|min:4|max:20'
        ];
    }
}

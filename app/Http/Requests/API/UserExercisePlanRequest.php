<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class UserExercisePlanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
   public function rules()
    {
        return [
            'day'                         => 'required|integer|in:1,2,3,4,5,6,7',
            'exercises'                   => 'required|array',
            'exercises.*.exercise_id'     => 'required|integer',
        ];
    }
}

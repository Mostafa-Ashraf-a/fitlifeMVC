<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkoutRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'title'                         => 'required',
            'workout_id'                    => 'required',
            'description'                   => 'sometimes',
            'goal_id'                       => 'required',
            'level_id'                      => 'required',
            'image'                         => 'sometimes|mimes:jpg,png,jpeg|max:5048',
        ];
    }
    public function messages()
    {
        return [

        ];
    }
}

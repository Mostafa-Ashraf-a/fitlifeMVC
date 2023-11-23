<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddWorkoutRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'title'                          => 'required',
            'description'                    => 'sometimes',
            'goal_id'                        => 'required',
            'level_id'                       => 'required',

            'exercise_type_day_1'             => 'sometimes',
            'body_part_day_1'                 => 'sometimes',
            'exercise_day_1'                  => 'sometimes',

            'exercise_type_day_2'             => 'sometimes',
            'body_part_day_2'                 => 'sometimes',
            'exercise_day_2'                  => 'sometimes',

            'exercise_type_day_3'             => 'sometimes',
            'body_part_day_3'                 => 'sometimes',
            'exercise_day_3'                  => 'sometimes',

            'exercise_type_day_4'             => 'sometimes',
            'body_part_day_4'                 => 'sometimes',
            'exercise_day_4'                  => 'sometimes',

            'exercise_type_day_5'             => 'sometimes',
            'body_part_day_5'                 => 'sometimes',
            'exercise_day_5'                  => 'sometimes',

            'exercise_type_day_6'             => 'sometimes',
            'body_part_day_6'                 => 'sometimes',
            'exercise_day_6'                  => 'sometimes',

            'exercise_type_day_7'            => 'sometimes',
            'body_part_day_7'                 => 'sometimes',
            'exercise_day_7'                 => 'sometimes',

            'type_id'                        => 'required',
            'image'                         => 'sometimes|mimes:jpg,png,jpeg|max:5048',
        ];
    }
    public function messages()
    {
        return [

        ];
    }
}

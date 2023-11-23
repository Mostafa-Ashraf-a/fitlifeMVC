<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExerciseRequest extends FormRequest
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
            'title_en'             => 'required',
            'title_ar'             => 'required',
            'equipment_id'         => 'sometimes|nullable',
            'level_id'             => 'sometimes|nullable',
            'rest'                 => 'sometimes|nullable',
            'sets'                 => 'sometimes|nullable',
            'reps'                 => 'sometimes|nullable',
            'video'               => 'sometimes|mimes:mp4|max:20000',
            'instruction_en'      => 'sometimes|nullable',
            'instruction_ar'      => 'sometimes|nullable',
            'tip_en'              => 'sometimes|nullable',
            'tip_ar'              => 'sometimes|nullable',
            'exercise_category'   => 'required',
            'body_part_id'        => 'required_if:exercise_category,1,2,3',
            'place'               => 'required|integer',
            'image'               => 'sometimes|mimes:jpg,png,jpeg|max:5048',
        ];
    }
    public function messages()
    {
        return [

        ];
    }
}

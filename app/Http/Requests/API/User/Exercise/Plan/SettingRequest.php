<?php

namespace App\Http\Requests\API\User\Exercise\Plan;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
   public function rules()
    {
        return [
            'exercise_id'   => 'sometimes|integer|exists:exercises,id',
            'day'           => 'required|in:1,2,3,4,5,6,7',
            'rest'          => 'sometimes|integer',
            'sets'          => 'sometimes|integer',
            'reps'          => 'sometimes|integer',
        ];
    }
}

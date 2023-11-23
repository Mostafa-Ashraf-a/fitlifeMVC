<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class ExercisePrgramSuggestionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'place_type'         => 'required|in:1,2',
            'days'               => 'required|in:2,3,4,5,6',
            'exercise_status'    => 'required|in:1,2,3'
            // 1 => Currently exercising , 2 => Years ago/Never exercised (1 month), 3 => Months ago (2 weeks)
        ];
    }
}

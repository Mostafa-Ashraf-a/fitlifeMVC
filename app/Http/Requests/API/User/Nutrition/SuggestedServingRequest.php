<?php

namespace App\Http\Requests\API\User\Nutrition;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class SuggestedServingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'starches'      => 'required|integer|min:0',
            'fruits'        => 'required|integer|min:0',
            'vegetables'    => 'required|integer|min:0',
            'meats'         => 'required|integer|min:0',
            'dairy'         => 'required|integer|min:0',
            'oils'          => 'required|integer|min:0',
        ];
    }
}

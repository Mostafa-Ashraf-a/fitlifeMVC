<?php

namespace App\Http\Requests\API\User\Nutrition;

use Illuminate\Foundation\Http\FormRequest;

class CreateMealRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'                             => 'required|min:3|max:25',
            'foodExchanges'                     => 'required|array',
            'foodExchanges.*.food_exchange_id'  => 'required|integer|exists:food_exchanges,id',
            'foodExchanges.*.quantity'          => 'required|integer|min:0',
        ];
    }
}

<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class UserMealPlanRequest extends FormRequest
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
        if (request()->isMethod('post')) {
            $nameEn = 'required';
        } elseif (request()->isMethod('put')) {
            $nameEn = 'sometimes';
        }
        return [
            'name_en' => $nameEn,
            'food_exchanges' => 'required|array',
            'food_exchanges.*.food_exchange_id' => 'required|integer',
        ];
    }
}

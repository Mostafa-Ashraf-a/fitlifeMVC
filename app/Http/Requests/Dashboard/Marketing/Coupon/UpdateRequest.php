<?php

namespace App\Http\Requests\Dashboard\Marketing\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'              => 'required',
            'code'              => 'required',
            'discount_type'     => 'required',
            'discount_value'    => 'required',
            'start_date'        => 'required',
            'end_date'          => 'required|date|after:start_date',
            'usage_limit'       => 'required',
        ];
    }
}

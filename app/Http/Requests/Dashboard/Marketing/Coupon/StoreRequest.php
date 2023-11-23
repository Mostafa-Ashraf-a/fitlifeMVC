<?php

namespace App\Http\Requests\Dashboard\Marketing\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'              => 'required',
            'code'              => 'required|size:6|unique:coupons',
            'discount_type'     => 'required',
            'discount_value'    => 'required',
            'start_date'        => 'required',
            'end_date'          => 'required|date|after:start_date',
            'usage_limit'       => 'required',
        ];
    }
}

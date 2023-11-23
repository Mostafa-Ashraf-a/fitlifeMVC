<?php

namespace App\Http\Requests\API\User\Subscription;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'coupon_code'  => 'sometimes|exists:coupons,code',
            'plan_id'      => 'required|exists:plan_management,id'
        ];
    }
}

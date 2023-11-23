<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionRequest extends FormRequest
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
            'plan_management_id'      => 'required|integer',
            'transaction_number'      => 'nullable',
            'card_brand'              => 'nullable',
            'card_first_six'          => 'nullable|digits:6',
            'coupon_code'             => 'sometimes|exists:coupons,code',
            'status'                  => 'required|in:1,0',
        ];
    }
}

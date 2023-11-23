<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanManagementRequest extends FormRequest
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
            'plan_name_en'     => 'required',
            'plan_name_ar'     => 'required',
            'plan_duration_id' => 'required|in:1,2,3,4,5,6',
            'trial_period'     => 'nullable',
            'price'            => 'required_if:plan_duration_id,2,3,4,5,6',
            'description_en'   => 'required',
            'description_ar'   => 'required',
            'features_en'      => 'required',
            'features_ar'      => 'required',
        ];
    }
}

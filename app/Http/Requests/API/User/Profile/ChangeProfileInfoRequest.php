<?php

namespace App\Http\Requests\API\User\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeProfileInfoRequest extends FormRequest
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
        $user = auth()->guard('user-api')->user();
        return [
            'mobile'   => [
                'required',
                'starts_with:5',
                'digits:9',
                Rule::unique('users')->ignore($user->id),
            ],
            'email'   => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
        ];
    }
}

<?php

namespace App\Http\Requests\API;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserDataRequest extends FormRequest
{
    use ApiResponse;
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
            'full_name'    => 'required',
            'email'        => 'required|email',
            'mobile'       => 'required|starts_with:5|digits:9',
            'password'     => 'required',
        ];
    }
    public function failedValidation(Validator $validator) {throw new HttpResponseException($this->error($validator->errors()->first(),422));}
}

<?php

namespace App\Http\Requests\API\User\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ChangeProfilePictureRequest extends FormRequest
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
//            'image'    => 'required|mimes:jpeg,png,jpg|max:2048'
            'image'    => 'required'
        ];
    }
}

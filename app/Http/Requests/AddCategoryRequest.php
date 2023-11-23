<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCategoryRequest extends FormRequest
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
            'title_en'                        => 'required',
            'title_ar'                        => 'required',
            'category_type_id'                => 'required',
            'image'                           => 'sometimes|mimes:jpg,png,jpeg|max:5048',
        ];
    }
    public function messages()
    {
        return [

        ];
    }
}

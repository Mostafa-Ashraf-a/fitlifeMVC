<?php

namespace App\Http\Requests\API;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class questionnaireResultRequest extends FormRequest
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
            'customer_info'              => 'required|array',
            'customer_info.gender'       => 'required|in:1,2',   // 1 for male & 2 for female
            'customer_info.age'          => 'required|numeric|min:10',
            'customer_info.height'       => 'required|numeric|min:50',
            'customer_info.weight'       => 'required|numeric|min:30',

            'question_1'                 => 'required|array',  // about goal (gain | maintain | lose)
            'question_1.question_id'     => 'required|integer',
            'question_1.answer_id'       => 'required|in:1,2,3',

            'question_2'                 => 'required|array',   // about Activity intensity
            'question_2.question_id'     => 'required|integer|in:2',
            'question_2.answer_id'       => 'required|in:4,5,6,7',

            'question_3'                 => 'sometimes|nullable|array',   // about intensity (body building level)
            'question_3.question_id'     => 'sometimes|nullable|integer|in:3',
            'question_3.answer_id'       => 'sometimes|nullable|in:8,9,10',

            'question_4'                 => 'sometimes|nullable|array',   // about do you want to gain
            'question_4.question_id'     => 'sometimes|nullable|integer|in:4',
            'question_4.answer_id'       => 'sometimes|nullable|in:11,12',

            'question_5'                 => 'sometimes|nullable|array',   // about do you want to lose
            'question_5.question_id'     => 'sometimes|nullable|integer|in:5',
            'question_5.answer_id'       => 'sometimes|nullable|in:13,14', // 13 => 0.5 kg, 14 => 1 kg


            'new_macronutrients_amount'                  => 'sometimes|nullable|array',
            'new_macronutrients_amount.answer'           => 'sometimes|nullable|in:1,2',   // 1=> yes , 2=>no
            'new_macronutrients_amount.protein_intake'   => 'required_if:new_macronutrients_amount.answer,1|numeric',
            'new_macronutrients_amount.carbs_intake'     => 'required_if:new_macronutrients_amount.answer,1|numeric',
            'new_macronutrients_amount.fats_intake'      => 'required_if:new_macronutrients_amount.answer,1|numeric',

            'body_fat_percentage_details'                       => 'sometimes|nullable|array',
            'body_fat_percentage_details.answer'                => 'sometimes|nullable|in:1,2',   // 1=> yes , 2=>no
            'body_fat_percentage_details.waist_circumference'   => 'required_if:body_fat_percentage_details.answer,1|numeric',
            'body_fat_percentage_details.neck_circumference'    => 'required_if:body_fat_percentage_details.answer,1|numeric',
            'body_fat_percentage_details.hip_circumference'     => 'required_if:body_fat_percentage_details.answer,1|numeric|lt:body_fat_percentage_details.waist_circumference',


//            'water_lost_exercise'                                 => 'sometimes|nullable|array',
//            'water_lost_exercise.weight_before_training'          => 'sometimes|nullable|numeric',
//            'water_lost_exercise.weight_after_training'           => 'sometimes|nullable|numeric',

            '1_rm_calculation'                         => 'sometimes|nullable|array',
            '1_rm_calculation.lifted_weight'           => 'sometimes|nullable|numeric',
            '1_rm_calculation.number_repetitions'      => 'sometimes|nullable|numeric',
        ];
    }
    public function failedValidation(Validator $validator) {throw new HttpResponseException($this->error($validator->errors()->first(),422));}
}

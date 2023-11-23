<?php

namespace App\Http\Requests\API\User\Nutrition;

use App\Models\Serving;
use Illuminate\Foundation\Http\FormRequest;

class UnderImplementationServingRequest extends FormRequest
{
    const UNDER_IMPLEMENTATION = 3;
    const USED_SERVING         = 2;
    const In_PROGRESS_PLAN     = 2;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $user = auth()->guard('user-api')->user()->id;
        $serving = Serving::where('user_id', $user)
            ->where('status', self::USED_SERVING)
            ->where('plan_status', self::In_PROGRESS_PLAN)
            ->first();
        if($serving)
        {
            return [
                'starches'      => 'required|integer|min:0|max:' . $serving->starches,
                'fruits'        => 'required|integer|min:0|max:' . $serving->fruits,
                'vegetables'    => 'required|integer|min:0|max:' . $serving->vegetables,
                'meats'         => 'required|integer|min:0|max:' . $serving->meats,
                'dairy'         => 'required|integer|min:0|max:' . $serving->dairy,
                'oils'          => 'required|integer|min:0|max:' . $serving->oils,
            ];
        }
        return [
            'starches'      => 'required|integer|min:0',
            'fruits'        => 'required|integer|min:0',
            'vegetables'    => 'required|integer|min:0',
            'meats'         => 'required|integer|min:0',
            'dairy'         => 'required|integer|min:0',
            'oils'          => 'required|integer|min:0',
        ];
    }
}

<?php

namespace App\Http\Resources\User\Nutrition\SubmittedPlan;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class DaysResource extends JsonResource
{
    public function toArray($request)
    {
       return [
           'days'  => $this->days(),
           'res'   => $this->whenLoaded()
        ];
    }


    public function days()
    {
        return DB::table('user_suggested_plan')
            ->where('user_id', auth()->guard('user-api')->user()->id)
            ->where('status', 1)
            ->groupBy('plan_id')
            ->get();
    }
}

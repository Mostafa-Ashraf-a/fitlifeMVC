<?php

namespace App\Http\Resources\UserExercisePlan;

use App\Http\Resources\User\Exercise\Plan\DaySettingResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserPlanResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'full_name'      => $this->full_name,
            'days'           => $this->whenLoaded('day', DayResource::collection($this->day)),
        ];
    }
}

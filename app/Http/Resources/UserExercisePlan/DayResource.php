<?php

namespace App\Http\Resources\UserExercisePlan;

use App\Http\Resources\User\Exercise\Plan\DaySettingResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DayResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'day_name'       => $this->value,
            'day_number'     => $this->day,
            'sets'           => $this->scopeExerciseDaySettingSets($this->day),
            'rest'           => $this->scopeExerciseDaySettingRest($this->day),
            'reps'           => $this->scopeExerciseDaySettingReps($this->day),
            'muscles'        => $this->whenLoaded('muscle', MuscleResource::collection($this->muscle)),
        ];
    }
}

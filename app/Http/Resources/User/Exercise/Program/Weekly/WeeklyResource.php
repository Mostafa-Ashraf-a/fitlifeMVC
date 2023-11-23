<?php

namespace App\Http\Resources\User\Exercise\Program\Weekly;

use Illuminate\Http\Resources\Json\JsonResource;

class WeeklyResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'full_name'      => $this->full_name,
            'has_program'    => $this->scopeHasRunningExerciseProgram(),
            'day'            => $this->whenLoaded('weeklyProgram', DaysResource::collection($this->weeklyProgram)),
        ];
    }
}

<?php

namespace App\Http\Resources\User\Exercise\Program\Weekly;

use Illuminate\Http\Resources\Json\JsonResource;

class DaysResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'day_number'     => $this->day,
            'value'          => $this->value,
            'exercise_type'     => $this->whenLoaded('weeklyExerciseType', ExerciseTypeResource::collection($this->weeklyExerciseType)),

        ];
    }
}

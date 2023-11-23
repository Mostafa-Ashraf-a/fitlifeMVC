<?php

namespace App\Http\Resources\User\Exercise\Program;


use Illuminate\Http\Resources\Json\JsonResource;

class DayResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'day_number'        => $this->day,
            'value'             => $this->value,
            'exercise_type'     => $this->whenLoaded('exerciseType', ExerciseTypeResource::collection($this->exerciseType)),
        ];
    }
}

<?php

namespace App\Http\Resources\User\Exercise\Program\Weekly;

use Illuminate\Http\Resources\Json\JsonResource;

class WeeklyMuscleResource extends JsonResource
{

    public function toArray($request)
    {
       return [
           'id'         => $this->id,
           'name'       => $this->title,
           'exercises'  => $this->whenLoaded('weeklyExerciseSuggestions',WeeklyExerciseResource::collection($this->weeklyExerciseSuggestions))
       ];
    }
}

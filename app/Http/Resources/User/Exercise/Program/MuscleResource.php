<?php

namespace App\Http\Resources\User\Exercise\Program;

use App\Http\Resources\ExerciseResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MuscleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->title,
            'exercises'  => $this->whenLoaded('exerciseSuggestions',ExerciseResource::collection($this->exerciseSuggestions))
        ];
    }
}

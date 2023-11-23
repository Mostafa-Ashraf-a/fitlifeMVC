<?php

namespace App\Http\Resources\User\Exercise\Program;

use Illuminate\Http\Resources\Json\JsonResource;

class ExerciseTypeResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'value'        => $this->value,
            'muscles'      => $this->whenLoaded('muscles', MuscleResource::collection($this->muscles)),
        ];
    }
}

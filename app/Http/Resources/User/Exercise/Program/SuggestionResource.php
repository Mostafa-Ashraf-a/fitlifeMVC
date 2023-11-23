<?php

namespace App\Http\Resources\User\Exercise\Program;

use Illuminate\Http\Resources\Json\JsonResource;

class SuggestionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'               => $this->id,
            'full_name'        => $this->full_name,
            'has_program'      => $this->scopeHasRunningExerciseProgram(),
            'day'              => $this->whenLoaded('program', DayResource::collection($this->program)),
        ];
    }
}

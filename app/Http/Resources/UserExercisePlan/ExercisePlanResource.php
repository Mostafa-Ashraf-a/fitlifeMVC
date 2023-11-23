<?php

namespace App\Http\Resources\UserExercisePlan;

use App\Http\Resources\UserExercisePlan\ExerciseResource as ExerciseResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ExercisePlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'user_id'                => $this->id,
            'user_name'              => $this->full_name,
            'body_part'               => $this->whenLoaded('userMusclePlan',MuscleResource::collection($this->userMusclePlan))
        ];
    }
}

<?php

namespace App\Http\Resources\UserExercisePlan;

use Illuminate\Http\Resources\Json\JsonResource;

class MuscleResource extends JsonResource
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
            'id'         => $this->id,
            'name'       => $this->title,
            'exercises'  => $this->whenLoaded('exercises',ExerciseResource::collection($this->exercises))
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserExercisePlan extends JsonResource
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
          'exercise'               => $this->whenLoaded('exercises',ExerciseResource::collection($this->exercises))
        ];
    }
}

<?php

namespace App\Http\Resources\UserExercisePlan;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ExerciseResource extends JsonResource
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
            'id'             => $this->id,
            'title'          => $this->title,
            'image'          => $this->image ? url(Storage::url('files/exercise/images/' . $this->id . '/thumb-' . $this->image)) : null,
        ];
    }
}

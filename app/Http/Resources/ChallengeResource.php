<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ChallengeResource extends JsonResource
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
          'id'            => $this->id,
          'title'         => $this->title,
          'description'   => $this->description,
           'image'        => $this->image ? url(Storage::url('files/challenges/images/' . $this->id . '/thumb-' . $this->image)) : null,
          'exercises'     => $this->whenLoaded('exercises',ExerciseResource::collection($this->exercises) ?? null)
        ];
    }
}

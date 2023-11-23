<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExerciseSettingResource extends JsonResource
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
            'instructions'   => $this->instructions,
            'tips'           => $this->tips,
            'place'          => $this->place,
            'type'           => $this->exercise_category,
            'level'          => $this->whenLoaded('level',$this->level->title ?? null),
            'image_url'      => $this->image_url,
            'video_url'      => $this->video_url,
            'created_at'     => $this->created_at,
            'day'            => $this->pivot->days ?? null,
            'body'           => $this->whenLoaded('bodyParts',BodyPartResource::collection($this->bodyParts) ?? null),
            'day_exercise_setting'    => $this->scopeExerciseDaySetting(request()->query('day')),
            'user_exercise_day_setting'    => $this->scopeUserExerciseDaySetting($this->id,request()->query('day')),
        ];
    }
}

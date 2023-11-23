<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ExerciseResource extends JsonResource
{
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
//            'image'          => $this->image ? url('storage/files/exercise/images/' . $this->id . '/thumb-' . $this->image,[],true) : null,
//            'video'          => $this->video ? url('storage/files/exercise/videos/' . $this->id . '/'. $this->video,[],true) : null,
            'image'          => $this->image ? secure_url(Storage::url('files/exercise/images/' . $this->id . '/thumb-' . $this->image)) : null,
            'video'          => $this->video ? secure_url(Storage::url('files/exercise/videos/' . $this->id . '/'. $this->video)) : null,
            'muscle'         => $this->whenLoaded('muscle',BodyPartResource::make($this->muscle) ?? null),
            'sets'           => $this->scopeExerciseDaySettingSets($this->id, \request()->query('day')),
            'rest'           => $this->scopeExerciseDaySettingRest($this->id, \request()->query('day')),
            'reps'           => $this->scopeExerciseDaySettingReps($this->id, \request()->query('day')),
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
        ];
    }
}

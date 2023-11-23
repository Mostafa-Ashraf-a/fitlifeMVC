<?php

namespace App\Http\Resources\User\Exercise\Program\Weekly;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class WeeklyExerciseResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'title'          => $this->title,
            'image'          => $this->image ? url(Storage::url('files/exercise/images/' . $this->id . '/thumb-' . $this->image)) : null,
        ];
    }
}

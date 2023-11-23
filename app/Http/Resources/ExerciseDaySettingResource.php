<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExerciseDaySettingResource extends JsonResource
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
          'id'    => $this->id,
          'day'   => $this->day,
          'rest'  => $this->rest,
          'sets'  => $this->sets,
          'reps'  => $this->reps,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkoutResource extends JsonResource
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
            'day'     => $this->whenLoaded('dayOne',DaysResource::collection($this->dayOne)),
//            'dayTwo'     => $this->whenLoaded('dayTwo',DaysResource::collection($this->dayTwo)),
//            'dayThree'   => $this->whenLoaded('dayThree',DaysResource::collection($this->dayThree)),
//            'dayFour'   => $this->whenLoaded('dayFour',DaysResource::collection($this->dayFour)),
//            'dayFive'   => $this->whenLoaded('dayFive',DaysResource::collection($this->dayFive)),
//            'daySix'   => $this->whenLoaded('daySix',DaysResource::collection($this->daySix)),
//            'daySeven'   => $this->whenLoaded('daySeven',DaysResource::collection($this->daySeven)),
        ];
    }
}

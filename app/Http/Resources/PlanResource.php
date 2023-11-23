<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{

    public function toArray($request)
    {
        return [
          'id'                  => $this->id,
          'plan_name'           => $this->plan_name,
          'description'         => $this->description,
          'features'            => $this->features,
          'is_free'             => $this->plan_duration_id != 1 ? 0 : 1,
          'is_trail_period'     => $this->trail_period > 0 ? 1 : 0,
          'trail_period'        => $this->trail_period,
          'trail_interval'      => $this->trail_interval,
          'currency'            => $this->currency,
          'price'               => $this->plan_duration_id != 1 ? $this->price : 0,
          'plan_duration'       => $this->whenLoaded('planDuration',PlanDurationResource::make($this->planDuration))
        ];
    }
}

<?php

namespace App\Http\Resources\User\Nutrition\History;

use Illuminate\Http\Resources\Json\JsonResource;

class SingleHistoryPlanResource extends JsonResource
{

    public function toArray($request)
    {
        return [

            'running_date'    => $this->start_date,
            'archived_date'   => $this->end_date,
            'plan'            => $this->whenLoaded('historyPlans', PlanResource::make($this->historyPlans))
        ];
    }
}

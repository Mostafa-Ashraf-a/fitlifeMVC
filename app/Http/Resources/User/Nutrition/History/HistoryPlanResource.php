<?php

namespace App\Http\Resources\User\Nutrition\History;

use Illuminate\Http\Resources\Json\JsonResource;

class HistoryPlanResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                     => $this->type == 1 ? $this->historyPlans->id : $this->plan_id,
            'title'                  => $this->historyPlans->title,
            'plan_type'              => [
               'value'              =>   $this->type,
               'value_string'       =>   $this->type == 1 ? 'custom' : 'suggested',
            ],
            'duration'               => $this->duration,
            'day_number'             => $this->day_number,

            'running_date'           => $this->start_date,
            'archived_date'          => $this->end_date,
        ];
    }
}

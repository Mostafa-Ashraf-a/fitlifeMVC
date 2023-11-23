<?php

namespace App\Http\Resources\User\Nutrition\SubmittedPlan;

use App\Http\Resources\User\Nutrition\MeasurementUnitResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FoodExchangeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                    => $this->id,
            'title'                 => $this->title,
            'food_type'             => $this->food_type_id,
            'measurement_units'     => $this->whenLoaded('measurementUnits', MeasurementUnitResource::collection($this->measurementUnits))
        ];
    }
}

<?php

namespace App\Http\Resources\User\Nutrition\History;

use App\Http\Resources\User\Nutrition\FoodTypeResource;
use App\Http\Resources\User\Nutrition\MeasurementUnitResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FoodExchangeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                   => $this->id,
            'title'                => $this->title,
            'image'                => $this->image ? url(Storage::url('files/foodExchanges/images/' . $this->id . '/thumb-' . $this->image)) : null,
            'quantity'             => $this->pivot->quantity ?? null,
            'food_type'            => $this->whenLoaded('foodType', FoodTypeResource::make($this->foodType)),
            'measurement_units'    => $this->whenLoaded('measurementUnits', MeasurementUnitResource::collection($this->measurementUnits)),
        ];
    }
}

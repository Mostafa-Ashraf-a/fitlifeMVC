<?php

namespace App\Http\Resources\User\Nutrition;

use Illuminate\Http\Resources\Json\JsonResource;

class MeasurementUnitResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'quantity'   => $this->pivot->quantity,

        ];
    }
}

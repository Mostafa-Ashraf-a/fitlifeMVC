<?php

namespace App\Http\Resources\User\Nutrition\Serving;

use Illuminate\Http\Resources\Json\JsonResource;

class UnderImplementationServingResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'starches'       => $this->starches,
            'fruits'         => $this->fruits,
            'vegetables'     => $this->vegetables,
            'meats'          => $this->meats,
            'dairy'          => $this->dairy,
            'oils'           => $this->oils,
        ];
    }
}

<?php

namespace App\Http\Resources\User\Nutrition\History;

use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'              => $this->id,
            'title'           => $this->title,
            'food_exchanges'  => $this->whenLoaded('historyFoodExchanges', FoodExchangeResource::collection($this->historyFoodExchanges)),
        ];
    }
}

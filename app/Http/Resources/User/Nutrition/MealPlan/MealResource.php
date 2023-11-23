<?php

namespace App\Http\Resources\User\Nutrition\MealPlan;

use App\Http\Resources\User\Nutrition\FoodExchangeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
{
    public function toArray($request)
    {
        return [
             'id'              => $this->id,
             'title'           => $this->title,
             'food_exchanges'  => $this->whenLoaded('foodExchanges', FoodExchangeResource::collection($this->foodExchanges)),
        ];
    }
}

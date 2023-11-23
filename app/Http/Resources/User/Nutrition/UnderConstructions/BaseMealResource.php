<?php

namespace App\Http\Resources\User\Nutrition\UnderConstructions;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseMealResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'     => $this->underConstructionMeals->id,
            'title'  => $this->underConstructionMeals->title,
            'meal'  => MealResource::make($this->whenLoaded('underConstructionMeals')),
        ];
    }
}

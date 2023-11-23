<?php

namespace App\Http\Resources\User\Nutrition\MealPlan;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'title'      => $this->title,
            'meals'      => $this->whenLoaded('meals', MealResource::collection($this->meals))
        ];
    }
}

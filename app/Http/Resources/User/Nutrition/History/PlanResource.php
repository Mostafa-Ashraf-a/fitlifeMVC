<?php

namespace App\Http\Resources\User\Nutrition\History;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'              =>  $this->id,
            'title'           => $this->title,
            'meals'           => $this->whenLoaded('historyMeals', MealResource::collection($this->historyMeals))
        ];
    }
}

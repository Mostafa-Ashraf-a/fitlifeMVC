<?php

namespace App\Http\Resources\User\Nutrition\MealPlan;

use Illuminate\Http\Resources\Json\JsonResource;

class UserMealResource extends JsonResource
{
    public function toArray($request)
    {
        return [
             'id'        => $this->id,
             'full_name' => $this->full_name,
             'meals'     => $this->whenLoaded('meals', MealResource::collection($this->meals))
        ];
    }
}

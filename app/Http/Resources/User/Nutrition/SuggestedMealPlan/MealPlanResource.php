<?php

namespace App\Http\Resources\User\Nutrition\SuggestedMealPlan;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class MealPlanResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'meal_type'   => $this->whenLoaded('suggestedMealTypes', MealTypeResource::collection($this->suggestedMealTypes))
        ];
    }
}

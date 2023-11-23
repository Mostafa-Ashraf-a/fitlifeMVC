<?php

namespace App\Http\Resources\User\Nutrition\SuggestedMealPlan;

use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id'       => $this->id,
            'title'    => $this->title,
            'recipes'  => $this->whenLoaded('recipes', RecipeResource::collection($this->recipes))
        ];
    }
}

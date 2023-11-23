<?php

namespace App\Http\Resources\User\Nutrition\SuggestedMealPlan;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MealTypeResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'      => $this->id,
            'title'   => $this->title,
            'image'   => $this->image ? url(Storage::url('files/mealTypes/images/' . $this->id . '/thumb-' . $this->image)) : null,
            'meals'    => $this->whenLoaded('mealTypeMeal', MealResource::collection($this->mealTypeMeal))
        ];
    }
}

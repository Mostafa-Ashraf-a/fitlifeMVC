<?php

namespace App\Http\Resources\User\Nutrition\SuggestedMealPlan;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class RecipeResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'      => $this->id,
            'title'   => $this->title,
            'image'   => url(Storage::url('files/recipes/images/' . $this->id . '/thumb-' . $this->image)) ?? null
        ];
    }
}

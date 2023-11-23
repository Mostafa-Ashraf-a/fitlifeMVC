<?php

namespace App\Http\Resources\User\Nutrition;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RecipeResource extends JsonResource
{
    public function toArray($request)
    {
        $duration = \request()->query('duration');
        $planId = \request()->query('plan_id');
        $dayNumber = \request()->query('day_number');
        return [
            'id'             => $this->id,
            'title'          => $this->title,
            'instructions'   => $this->instructions,
            'other_info'     => $this->other_info,
            'macronutrients' => $this->getMacronutrients($this->id, $duration,$planId, $dayNumber),
            'image'          => $this->image ? url(Storage::url('files/recipes/images/' . $this->id . '/thumb-' . $this->image)) : null,
            'ingredients'    => $this->whenLoaded('foodExchanges', FoodExchangeResource::collection($this->foodExchanges))
        ];
    }

    public function getMacronutrients($recipeId, $duration, $planId, $dayNumber)
    {
        return DB::table('user_suggested_plan')
            ->where('user_id', auth()->guard('user-api')->user()->id)
            ->where('recipe_id', $recipeId)
            ->where('plan_id', $planId)
            ->where('duration', $duration)
            ->where('day_number', $dayNumber)
            ->select('cal','proteins','carbs','fats')
            ->first();
    }
}

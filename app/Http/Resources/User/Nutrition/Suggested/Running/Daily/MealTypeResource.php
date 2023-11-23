<?php

namespace App\Http\Resources\User\Nutrition\Suggested\Running\Daily;

use App\Http\Resources\User\Nutrition\SubmittedPlan\RecipeResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MealTypeResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'title'     => $this->title,
            'image'     => $this->image ? secure_url(Storage::url('files/mealTypes/images/' . $this->id . '/thumb-' . $this->image)) : null,
            'cal'       => $this->calculateCal($this->pivot->plan_id, $this->id, $this->pivot->duration),
            'proteins'  => $this->calculateProteins($this->pivot->plan_id, $this->id, $this->pivot->duration),
            'carbs'     => $this->calculateCarbs($this->pivot->plan_id, $this->id, $this->pivot->duration),
            'fats'      => $this->calculateFats($this->pivot->plan_id, $this->id, $this->pivot->duration),
            'recipes'   => $this->whenLoaded('dailyRunningSuggestedRecipes', RecipeResource::collection($this->dailyRunningSuggestedRecipes))
        ];
    }

    public function calculateCal($planId, $mealTypeId, $duration)
    {
        $user = auth()->guard('user-api')->user();

        return DB::table('user_suggested_plan')
            ->where('plan_id', $planId)
            ->where('duration', $duration)
            ->where('user_id', $user->id)
            ->where('meal_type_id', $mealTypeId)
            ->sum('cal');
    }

    public function calculateProteins($planId, $mealTypeId, $duration)
    {
        $user = auth()->guard('user-api')->user();

        return DB::table('user_suggested_plan')
            ->where('plan_id', $planId)
            ->where('duration', $duration)
            ->where('user_id', $user->id)
            ->where('meal_type_id', $mealTypeId)
            ->sum('proteins');
    }

    public function calculateCarbs($planId, $mealTypeId, $duration)
    {
        $user = auth()->guard('user-api')->user();

        return DB::table('user_suggested_plan')
            ->where('plan_id', $planId)
            ->where('duration', $duration)
            ->where('user_id', $user->id)
            ->where('meal_type_id', $mealTypeId)
            ->sum('carbs');
    }

    public function calculateFats($planId, $mealTypeId, $duration)
    {
        $user = auth()->guard('user-api')->user();

        return DB::table('user_suggested_plan')
            ->where('plan_id', $planId)
            ->where('duration', $duration)
            ->where('user_id', $user->id)
            ->where('meal_type_id', $mealTypeId)
            ->sum('fats');
    }
}

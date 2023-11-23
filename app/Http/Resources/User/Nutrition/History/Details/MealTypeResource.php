<?php

namespace App\Http\Resources\User\Nutrition\History\Details;

use App\Http\Resources\User\Nutrition\SubmittedPlan\RecipeResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class MealTypeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'title'     => $this->title,
            'cal'      => $this->calculateCal($this->pivot->plan_id, $this->id, $this->pivot->duration),
            'proteins' => $this->calculateProteins($this->pivot->plan_id, $this->id, $this->pivot->duration),
            'carbs'    => $this->calculateCarbs($this->pivot->plan_id, $this->id, $this->pivot->duration),
            'fats'     => $this->calculateFats($this->pivot->plan_id, $this->id, $this->pivot->duration),
            'recipes'  => $this->whenLoaded('historySuggestedRecipes', RecipeResource::collection($this->historySuggestedRecipes))
        ];
    }

    public function calculateCal($planId, $mealTypeId, $duration)
    {
        return DB::table('user_suggested_plan')
            ->where('plan_id', $planId)
            ->where('duration', $duration)
            ->where('user_id', auth()->guard('user-api')->user()->id)
            ->where('meal_type_id', $mealTypeId)
            ->sum('cal');
    }
    public function calculateProteins($planId, $mealTypeId, $duration)
    {
        return DB::table('user_suggested_plan')
            ->where('plan_id', $planId)
            ->where('duration', $duration)
            ->where('user_id', auth()->guard('user-api')->user()->id)
            ->where('meal_type_id', $mealTypeId)
            ->sum('proteins');
    }
    public function calculateCarbs($planId, $mealTypeId, $duration)
    {
        return DB::table('user_suggested_plan')
            ->where('plan_id', $planId)
            ->where('duration', $duration)
            ->where('user_id', auth()->guard('user-api')->user()->id)
            ->where('meal_type_id', $mealTypeId)
            ->sum('carbs');
    }
    public function calculateFats($planId, $mealTypeId, $duration)
    {
        return DB::table('user_suggested_plan')
            ->where('plan_id', $planId)
            ->where('duration', $duration)
            ->where('user_id', auth()->guard('user-api')->user()->id)
            ->where('meal_type_id', $mealTypeId)
            ->sum('fats');
    }
}

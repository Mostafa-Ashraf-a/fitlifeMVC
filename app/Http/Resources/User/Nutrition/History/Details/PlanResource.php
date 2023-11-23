<?php

namespace App\Http\Resources\User\Nutrition\History\Details;

use App\Http\Resources\User\Nutrition\History\Details\MealTypeResource as HistoryDetailsMealTypeResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class PlanResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                       => $this->id,
            'title'                    => $this->title,
            'duration'                 => $this->historyMealTypes->first()->pivot->duration,
            'day_number'               => $this->historyMealTypes->first()->pivot->day_number,
            'serving_per_food_types'   => $this->servingPerFoodType($this->id,$this->historyMealTypes->first()->pivot->duration, $this->historyMealTypes->first()->pivot->day_number),
            'meal_types'               => $this->whenLoaded('historyMealTypes', HistoryDetailsMealTypeResource::collection($this->historyMealTypes))
        ];
    }

    private function servingPerFoodType($planId, $duration, $dayNumber)
    {
        $serving = DB::table('user_serving_per_food_type')
            ->where('plan_id', $planId)
            ->where('duration', $duration)
            ->where('day_number', $dayNumber)
            ->where('status', 1)
            ->where('user_id', auth()->guard('user-api')->user()->id)
            ->first();
        return [
            [
                'id'             => 1,
                'serving_value'  => $serving->Starches
            ],
            [
                'id'             => 2,
                'serving_value'  => $serving->Fruits
            ],
            [
                'id'             => 3,
                'serving_value'  => $serving->Vegetables
            ],
            [
                'id'             => 4,
                'serving_value'  => $serving->Meats
            ],
            [
                'id'             => 5,
                'serving_value'  => $serving->Dairy
            ],
            [
                'id'             => 6,
                'serving_value'  => $serving->Oils
            ]
        ];
    }
}

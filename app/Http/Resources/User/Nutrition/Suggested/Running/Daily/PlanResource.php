<?php

namespace App\Http\Resources\User\Nutrition\Suggested\Running\Daily;

use App\Http\Resources\User\Nutrition\Suggested\Running\Daily\MealTypeResource as DailyRunningMealTypeResource;
use App\Models\CalculationResult;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class PlanResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                       => $this->id,
            'title'                    => $this->title,
            'duration'                 => $this->dailyRunningMealTypes->first()->pivot->duration,
            'day_number'               => $this->dailyRunningMealTypes->first()->pivot->day_number,
            'serving_per_food_types'   => $this->servingPerFoodType($this->id, $this->dailyRunningMealTypes->first()->pivot->duration, $this->dailyRunningMealTypes->first()->pivot->day_number),
            'meal_types'               => $this->whenLoaded('dailyRunningMealTypes', DailyRunningMealTypeResource::collection($this->dailyRunningMealTypes))
        ];
    }

    private function servingPerFoodType($planId, $duration, $dayNumber)
    {
        // $user = User::find(auth()->id());

        // $user_servings = CalculationResult::where('user_id', $user->id)->select([
        //     "starches",
        //     "fruits",
        //     "vegetables",
        //     "meats",
        //     "dairy",
        //     "oils"
        // ])->first()->toArray();

        // $meal_plan_servings = [
        //     "starches" => 0,
        //     "fruits" => 0,
        //     "vegetables" => 0,
        //     "meats" => 0,
        //     "dairy" => 0,
        //     "oils" => 0
        // ];

        // $meals = $this->dailyRunningMealTypes;

        // foreach ($meals as $meal) {
        //     $recipes = $meal->dailyRunningSuggestedRecipes;

        //     foreach ($recipes as $recipe) {

        //         foreach ($recipe->foodExchanges as $foodExchange) {

        //             if ($foodExchange->food_type_id == 1) {
        //                 $meal_plan_servings["starches"] += 1;
        //             }
        //             if ($foodExchange->food_type_id == 2) {
        //                 $meal_plan_servings["fruits"] += 1;
        //             }
        //             if ($foodExchange->food_type_id == 3) {
        //                 $meal_plan_servings["vegetables"] += 1;
        //             }
        //             if ($foodExchange->food_type_id == 4) {
        //                 $meal_plan_servings["meats"] += 1;
        //             }
        //             if ($foodExchange->food_type_id == 5) {
        //                 $meal_plan_servings["dairy"] += 1;
        //             }
        //             if ($foodExchange->food_type_id == 6) {
        //                 $meal_plan_servings["oils"] += 1;
        //             }
        //         }
        //     }
        // }

        // divide user servings by meal plan servings and multiply by meal plan servings

        // $starches = ($user_servings["starches"] / $meal_plan_servings["starches"]) * $user_servings['starches'];
        // $fruits = ($user_servings["fruits"] / $meal_plan_servings["fruits"]) * $user_servings['fruits'];
        // $vegetables = ($user_servings["vegetables"] / $meal_plan_servings["vegetables"]) * $user_servings['vegetables'];
        // $meats = ($user_servings["meats"] / $meal_plan_servings["meats"]) * $user_servings['meats'];
        // $dairy = ($user_servings["dairy"] / $meal_plan_servings["dairy"]) * $user_servings['dairy'];
        // $oils = ($user_servings["oils"] / $meal_plan_servings["oils"]) * $user_servings['oils'];

        // round up to nearest whole number

        // $starches = ceil($starches);
        // $fruits = ceil($fruits);
        // $vegetables = ceil($vegetables);
        // $meats = ceil($meats);
        // $dairy = ceil($dairy);
        // $oils = ceil($oils);


        // dd(
        //     "starches: " . $starches,
        //     "fruits: " . $fruits,
        //     "vegetables: " . $vegetables,
        //     "meats: " . $meats,
        //     "dairy: " . $dairy,
        //     "oils: " . $oils,

        //     "User Servings",
        //     $user_servings,
        //     "Meal Plan Servings",
        //     $meal_plan_servings
        // );


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
            ],
        ];
    }
}

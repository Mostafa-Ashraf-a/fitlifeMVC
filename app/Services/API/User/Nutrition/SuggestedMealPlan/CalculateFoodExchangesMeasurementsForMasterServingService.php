<?php

namespace App\Services\API\User\Nutrition\SuggestedMealPlan;

use App\Models\FoodExchange;
use App\Models\MealPlan;
use App\Models\MealType;
use App\Models\Recipe;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CalculateFoodExchangesMeasurementsForMasterServingService
{
    const WEEKLY_PLAN        = 2;
    const ACTIVE_WEEKLY_PLAN = 1;

    const Starches_ID   = 1;
    const Fruits_ID     = 2;
    const Vegetables_ID = 3;
    const Meats_ID      = 4;
    const Dairy_ID      = 5;
    const Oils_ID       = 6;

    public function execute(User $user,$recipes,$servingPerFoodType)
    {
//        dd($servingPerFoodType);
//        $recipes = Recipe::whereIn('id',[7,4,6])->with('foodExchanges.measurementUnits')->get();
//        dd(collect($recipes)->pluck('id'));
        ini_set('max_execution_time',5);
        $servingPerFoodType = $this->mapServingPerFoodType($servingPerFoodType);
        $recipes = $this->mapRecipes($recipes);
//        dd($recipes);
//        dd($recipes[0]);
//        dd(\Arr::last($recipes[0]));
        foreach ($servingPerFoodType as $typeId => $value ) {
//            if ($typeId != 4) continue;
//            dump('in for each with value.'.$value);
            while ($value > 0){
//                dump('in while with value.'.$value);
            $recipes = $recipes->map(function ($recipe) use ($typeId,&$value) {
//               if ($value < 0) return $recipe;
                $recipe[ 'foodExchanges' ] = $recipe[ 'foodExchanges' ]->map(function ($foodExchange) use ($typeId,&$value) {
//                    if ($value == -1) return $foodExchange;
                    if ( $foodExchange[ 'food_type_id' ] == $typeId && $value ) {
//                    dump($foodExchange);
//                        dump($foodExchange['food_exchange_id']);
                        $value-= 1;
                        $foodExchange[ 'measurementUnits' ] = $foodExchange[ 'measurementUnits' ]->map(function ($unit) use ($foodExchange,&$value) {
//                            if ($value == 0) return $unit;
//                            dump($value);
//                            dump($unit);
//                            dump($foodExchange['food_exchange_id']);
//                            dump($unit);
//                            if ( !isset($unit[ 'plan_quantity' ]) )
//                                $unit[ 'plan_quantity' ] = 0;

                            $unit[ 'plan_quantity' ] =     ($unit[ 'plan_quantity' ] ?? 0) + $unit[ 'quantity' ];
//                            dump($unit[ 'quantity' ], $unit[ 'plan_quantity' ]);
//                            dump($unit);

                            return $unit;
                        });
                    }
                    return $foodExchange;
                });
                return $recipe;
            });
            }
        }
//        dd($recipes);
        $result = [];
        $recipes->each(function ($recipe) use(&$result){
            foreach ($recipe['foodExchanges'] as $foodExchange){
                foreach ($foodExchange['measurementUnits']as $measurementUnit){
                    $result[$foodExchange['food_type_id']][$foodExchange['food_exchange_id']][$measurementUnit['measurement_unit_id']]['plan_quantity'] = $measurementUnit['plan_quantity'] ?? 0;
                    $result[$foodExchange['food_type_id']][$foodExchange['food_exchange_id']][$measurementUnit['measurement_unit_id']]['quantity'] = $measurementUnit['quantity'] ?? 0;
                }
            }
        });
        $compare = [];
        $finalJson=[];

        foreach ($result as $foodTypeId => $value){
            $foodTypeData = [
                "food_type_id" => $foodTypeId,
                'need_quantity' => $servingPerFoodType[$foodTypeId],
                "needs" => []
            ];
            $compare[$foodTypeId] =0;
            foreach ( $value as $foodExchangeId => $value2 ) {
                $foodExchangeData = [
                    "food_exchange_id" => $foodExchangeId,
                    "measurement_units" => []
                ];
                foreach ($value2 as $measurementUnitId => $value3){
                    $measurementUnitData = [
                        "unit_id" => $measurementUnitId,
                        "quantity" => $value3['quantity'],
                        "plan_quantity" => $value3['plan_quantity'],
                        "needs_count" => $value3['plan_quantity']  / $value3['quantity']
                    ];
                    $compare[$foodTypeId] +=$measurementUnitData['needs_count'];
                    $foodExchangeData["measurement_units"][] = $measurementUnitData;
                }
                $foodTypeData["needs"][] = $foodExchangeData;

            }
            $finalJson[] = $foodTypeData;

        }

        //what the api needs is final json
        return compact('recipes','compare','finalJson','result');
    }

    function dummy()
    {
        //        $plan = $this->getPlan();
//        dd($plan->dailyRunningMealTypes->pluck('pivot.recipe_id'));
//        $plan = MealPlan::whereHas('mealTypes')->first();
//        dd($plan);
//        $mealTypes = $plan->dailyRunningMealTypes()->with('recipes.foodExchanges')->get();
//        $mealTypes = MealType::whereHas('recipes.foodExchanges')->limit(3)->get();
//        dd($mealTypes);
//        $mealTypes = $plan->dailyRunningMealTypes;
//        $foodExchangesTypesIds = $mealTypes->map(function (MealType $mealType) {
////            dd($mealType);
//            return [
//                'meal_type_id' => $mealType->id,
//                'recipes'      => Recipe::whereIn('id',[$mealType->pivot->recipe_id])->get()->map(function (Recipe $recipe) {
//                    return [
//                        'recipe_id'     => $recipe->id,
//                        'foodExchanges' => $recipe->foodExchanges->map(function (FoodExchange $foodExchange) {
//                            dd($foodExchange->pluck('food_type_id'));
//                            return [
//                                'food_exchange_id' => $foodExchange->id,
//                                'food_types_ids'   => $foodExchange->pluck('food_type_id')
//                            ];
//                        })
//                    ];
//                })
//            ];
//        });
//        dd($foodExchangesTypesIds);


//        dd($user->masterServing);
    }

    public function getPlan() : MealPlan
    {
        $now = Carbon::now('Asia/Riyadh')->format('Y-m-d');

        $plan = MealPlan::query()
                        ->whereHas('dailyRunningMealTypes', function ($query) use ($now) {
                            $query->where('status', '=', 1)
                                  ->whereDate('start_date', '<=', $now)
                                  ->whereDate('end_date', '>=', $now);
                        })->whereHas('dailyRunningMealTypes.dailyRunningSuggestedRecipes', function ($query) use ($now) {
                $query->where('status', '=', 1)
                      ->whereDate('start_date', '<=', $now)
                      ->whereDate('end_date', '>=', $now);
            })->first();


        if ( $plan && ($plan->dailyRunningMealTypes->count() != 0) )
            return $plan;

        $yesterday = Carbon::yesterday('Asia/Riyadh')->format('Y-m-d');

        $getLastDailyRunningPlan = DB::table('user_suggested_plan')
                                     ->where('user_id', auth()->guard('user-api')->user()->id)
                                     ->where('duration', 1)
                                     ->where('status', self::ACTIVE_WEEKLY_PLAN)
                                     ->where('end_date', $yesterday)
                                     ->select('plan_id', 'duration', 'day_number')
                                     ->first();
        if ( $getLastDailyRunningPlan )
            return MealPlan::findOrFail($getLastDailyRunningPlan->plan_id);


        $getLastWeeklyRunningPlan = DB::table('user_suggested_plan')
                                      ->where('user_id', auth()->guard('user-api')->user()->id)
                                      ->where('duration', 2)
                                      ->where('status', self::ACTIVE_WEEKLY_PLAN)
                                      ->where('end_date', $yesterday)
                                      ->select('plan_id', 'duration', 'day_number')
                                      ->latest()
                                      ->first();


        if ( $getLastWeeklyRunningPlan )
            return MealPlan::findOrFail($getLastWeeklyRunningPlan->plan_id);

    }

    private function mapServingPerFoodType($servingPerFoodType)
    {
        return collect($servingPerFoodType)->mapWithKeys(function ($value, $type) {
            $typeId = null;
            switch ($type) {
                case 'Starches':
                    $typeId = self::Starches_ID;
                    break;
                case 'Fruits':
                    $typeId = self::Fruits_ID;
                    break;
                case 'Vegetables':
                    $typeId = self::Vegetables_ID;
                    break;
                case 'Meats':
                    $typeId = self::Meats_ID;
                    break;
                case 'Dairy':
                    $typeId = self::Dairy_ID;
                    break;
                case 'Oils':
                    $typeId = self::Oils_ID;
                    break;
            }
            return [
                $typeId => $value
            ];
        });
    }

    /**
     * @param $recipes
     * @return \Illuminate\Support\Collection
     */
    private function mapRecipes($recipes): \Illuminate\Support\Collection
    {
        return collect($recipes)->map(function (Recipe $recipe) {
            return [
                'recipe_id'     => $recipe->id,
                'foodExchanges' => $recipe->foodExchanges->map(function (FoodExchange $foodExchange) {
                    return [
                        'food_exchange_id' => $foodExchange->id,
                        'food_type_id'     => $foodExchange->food_type_id,
                        'measurementUnits' => $foodExchange->measurementUnits->map(function ($unit) {
                            return [
                                'measurement_unit_id' => $unit->id,
                                'quantity'            => $unit->pivot->quantity
                            ];
                        })
                    ];
                })
            ];
        });
    }
}

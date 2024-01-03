<?php


namespace App\Services\API\User\Nutrition\SuggestedMealPlan;


use App\Models\Recipe;
use App\Models\Serving;
use App\Models\UserMealPlan;
use App\Services\API\User\Nutrition\HistoryPlanService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MealPlanService
{
    const  IN_PROGRESS           = 2;
    public function moveDailyToHistory($user, $request, HistoryPlanService $historyService): void
    {
        $checkRequestedPlan = DB::table('user_suggested_plan')
            ->where('user_id', $user->id)
            ->where('duration', 1)
            ->where('plan_id', $request->plan_id)
            ->where('day_number', 0)
            ->where('status', 1)
            ->first();

        if (!$checkRequestedPlan)
        {
            $checkDailyPlan = DB::table('user_suggested_plan')
                ->where('user_id', $user->id)
                ->where('duration', 1)
                ->where('day_number', 0)
                ->where('status', 1)
                ->first();
            if ($checkDailyPlan)
            {
                $historyService->createHistoryPlanFromSuggested($user, $checkDailyPlan->plan_id, $checkDailyPlan->start_date, $checkDailyPlan->duration, $checkDailyPlan->day_number);
                DB::table('user_suggested_plan')
                    ->where('user_id', $user->id)
                    ->where('plan_id', $checkDailyPlan->plan_id)
                    ->where('duration', 1)
                    ->where('day_number', 0)
                    ->where('status', 1)
                    ->update([
                        'status' => 0
                    ]);
            }
        }
    }

    public function moveExistingWeeklyToHistory($user, $request, HistoryPlanService $historyPlanService)
    {
        $plans = DB::table('user_suggested_plan')
            ->where('user_id', $user->id)
            ->where('duration', 2)
            ->where('status', 1)
            ->groupBy('plan_id')
            ->get();
        if(count($plans) > 0)
        {
            foreach ($plans as $plan)
            {
                $historyPlanService->createHistoryPlanFromSuggested($user, $plan->plan_id, $plan->start_date, $plan->duration, $plan->day_number);
                DB::table('user_suggested_plan')
                    ->where('user_id', $user->id)
                    ->where('plan_id', $plan->plan_id)
                    ->where('duration', $plan->duration)
                    ->where('day_number', $plan->day_number)
                    ->where('status', 1)
                    ->update([
                        'status' => 0
                    ]);
            }
        }
    }

    public function checkExistingDailyPlan($user, $request)
    {
        $historyService = new HistoryPlanService();
        $this->moveExistingWeeklyToHistory($user, $request, $historyService);
        $this->moveDailyToHistory($user, $request, $historyService);
    }

    public function checkExistingWeeklyPlan($user, $request)
    {
        $historyService = new HistoryPlanService();
        $this->moveDailyToHistory($user, $request, $historyService);
        $weekPlan = DB::table('user_suggested_plan')
            ->where('user_id', $user->id)
            ->groupBy('plan_id')
            ->where('duration', 2)
            ->orderBy('day_number')
            ->where('status', 1)
            ->get();
        if(count($weekPlan) == 7)
        {
            $this->moveExistingWeeklyToHistory($user, $request, $historyService);
        }
    }

    public function reviewPlan($request, $user)
    {
        $starches = 0;
        $fruits = 0;
        $vegetables = 0;
        $meats = 0;
        $dairy = 0;
        $oils = 0;

        DB::beginTransaction();
        if($request->duration == 1)
        {
            $this->checkExistingDailyPlan($user, $request);
        }
        if($request->duration == 2)
        {
            $this->checkExistingWeeklyPlan($user, $request);
        }
        $checkRequestDuration = $this->checkPlanRequestDuration($request, $user);
        $recipes = [];
        foreach ($request->recipes as $recipe)
        {
            $foodExchanges = Recipe::query()
                ->where('id', $recipe['recipe_id'])
                ->with('foodExchanges.measurementUnits')
                ->first();
            $recipes[] = $foodExchanges;

            $this->createUserSuggestedPlan($request, $user, $recipe, $checkRequestDuration);
            list($starches, $fruits, $vegetables, $meats, $dairy, $oils) = $this->countFoodType($foodExchanges, $starches, $fruits, $vegetables, $meats, $dairy, $oils, $request, $user, $recipe);
        }

        $servingPerFoodType = $this->servingPerFoodType($user, $starches, $fruits, $vegetables, $meats, $dairy, $oils);
        $this->createServingPerFoodType($request, $user, $servingPerFoodType);
//        app(CalculateFoodExchangesMeasurementsForMasterServingService::class)->execute($user,$recipes,$servingPerFoodType);
        DB::commit();
    }

    public function servingPerFoodType($user, $starches, $fruits, $vegetables, $meats, $dairy, $oils) : array
    {
        $masterServing = Serving::query()
            ->where('user_id', $user->id)
            ->where('status', 1)
            ->first();

        return [
            'Starches'        => $masterServing->starches ,
            'Fruits'          => $masterServing->fruits ,
            'Vegetables'      => $masterServing->vegetables ,
            'Meats'           => $masterServing->meats ,
            'Dairy'           => $masterServing->dairy ,
            'Oils'            => $masterServing->oils ,
        ];
    }

    public function countFoodType(?\Illuminate\Database\Eloquent\Model $foodExchanges, int $starches, int $fruits, int $vegetables, int $meats, int $dairy, int $oils, $request, $user, $recipe): array
    {
        $starchesCalc = 0;
        $fruitsCalc = 0;
        $vegetablesCalc = 0;
        $meatsCalc = 0;
        $dairyCalc = 0;
        $oilsCalc = 0;
        foreach ($foodExchanges->foodExchanges as $foodExchange) {
            if ($foodExchange->food_type_id == 1) {
                $starches += 1;
                $starchesCalc += 1;
            } elseif ($foodExchange->food_type_id == 2) {
                $fruits += 1;
                $fruitsCalc += 1;
            } elseif ($foodExchange->food_type_id == 3) {
                $vegetables += 1;
                $vegetablesCalc += 1;
            } elseif ($foodExchange->food_type_id == 4) {
                $meats += 1;
                $meatsCalc += 1;
            } elseif ($foodExchange->food_type_id == 5) {
                $dairy += 1;
                $dairyCalc += 1;
            } else {
                $oilsCalc += 1;
            }
            $this->updateCalProteinCarbsFats($request, $user, $recipe, $starchesCalc, $fruitsCalc, $vegetablesCalc, $meatsCalc, $dairyCalc, $oilsCalc);
        }
        return array($starches, $fruits, $vegetables, $meats, $dairy, $oils);
    }

    public function updateCalProteinCarbsFats($request, $user, $recipe, int $starches, int $fruits, int $vegetables, int $meats, int $dairy, int $oils): void
    {
        DB::table('user_suggested_plan')
            ->where('plan_id', $request->plan_id)
            ->where('duration', $request->duration)
            ->where('user_id', $user->id)
            ->where('meal_type_id', $recipe['meal_type_id'])
            ->where('recipe_id', $recipe['recipe_id'])
            ->update(
                [
                    'cal' => ($starches * 80) + ($fruits * 60) + ($vegetables * 25) + ($meats * 75) + ($dairy * 120) + ($oils * 40),
                    'proteins' => ($starches * 3) + ($fruits * 0) + ($vegetables * 2) + ($meats * 7) + ($dairy * 8) + ($oils * 0),
                    'carbs' => ($starches * 15) + ($fruits * 15) + ($vegetables * 5) + ($meats * 0) + ($dairy * 12) + ($oils * 0),
                    'fats' => ($starches * 0) + ($fruits * 0) + ($vegetables * 0) + ($meats * 5) + ($dairy * 5) + ($oils * 5),
                ]
            );
    }

    public function checkPlanRequestDuration($request, $user)
    {
        $startDate = null;
        $endDate = null;
        $dayNumber = null;
        if($request->duration == 1)
        {
            $startDate = Carbon::now('Asia/Riyadh')->format('Y-m-d');
            $endDate = Carbon::now('Asia/Riyadh')->addDays(1)->format('Y-m-d');
            $dayNumber = 0;
        }
        if($request->duration == 2)
        {
            $checkPlan = DB::table('user_suggested_plan')
                ->where('user_id', $user->id)
                ->where('duration', 2)
                ->where('status','=',1)
                ->latest()
                ->first();
            if($checkPlan)
            {
                $startDate = Carbon::now('Asia/Riyadh')->parse($checkPlan->end_date)->addDays(1)->format('Y-m-d');
                $endDate = Carbon::now('Asia/Riyadh')->parse($startDate)->addDays(1)->format('Y-m-d');
                $dayNumber = $request->day_number;
            }
            else{
                $startDate =  Carbon::now('Asia/Riyadh')->format('Y-m-d');
                $endDate =  Carbon::now('Asia/Riyadh')->addDays(1)->format('Y-m-d');
                $dayNumber = $request->day_number;
            }

        }
        return [
            'start_date'  => $startDate,
            'end_date'    => $endDate,
            'day_number'  => $dayNumber
        ];
    }

    public function createServingPerFoodType($request, $user, array $servingPerFoodType): void
    {
        DB::table('user_serving_per_food_type')
            ->updateOrInsert(
                [
                    'plan_id' => $request->plan_id,
                    'duration' => $request->duration,
                    'user_id' => $user->id,
                    'day_number' => $request->duration == 1 ? 0 : $request->day_number,
                    'status' => 2,
                    'Starches' => 0,
                    'Fruits' => 0,
                    'Vegetables' => 0,
                    'Meats' => 0,
                    'Dairy' => 0,
                    'Oils' => 0,
                ],
                [
                    'plan_id' => $request->plan_id,
                    'duration' => $request->duration,
                    'user_id' => $user->id,
                    'day_number' => $request->duration == 1 ? 0 : $request->day_number,
                    'status' => 2,
                    'Starches' => 0,
                    'Fruits' => 0,
                    'Vegetables' => 0,
                    'Meats' => 0,
                    'Dairy' => 0,
                    'Oils' => 0,
                ]
            );
        DB::table('user_serving_per_food_type')
            ->updateOrInsert(
                [
                    'plan_id' => $request->plan_id,
                    'duration' => $request->duration,
                    'user_id' => $user->id,
                    'day_number' => $request->duration == 1 ? 0 : $request->day_number,
                    'status' => 1
                ],
                [
                    'plan_id' => $request->plan_id,
                    'duration' => $request->duration,
                    'user_id' => $user->id,
                    'day_number' => $request->duration == 1 ? 0 : $request->day_number,
                    'status' => 1,
                    'Starches' => $servingPerFoodType['Starches'],
                    'Fruits' => $servingPerFoodType['Fruits'],
                    'Vegetables' => $servingPerFoodType['Vegetables'],
                    'Meats' => $servingPerFoodType['Meats'],
                    'Dairy' => $servingPerFoodType['Dairy'],
                    'Oils' => $servingPerFoodType['Oils'],
                ]
            );
    }

    public function createUserSuggestedPlan($request, $user, $recipe, array $checkRequestDuration): void
    {
        DB::table('user_suggested_plan')
            ->updateOrInsert(
                [
                    'plan_id'        => $request->plan_id,
                    'duration'       => $request->duration,
                    'user_id'        => $user->id,
                    'meal_type_id'   => $recipe['meal_type_id'],
                    'recipe_id'      => $recipe['recipe_id'],
                    'day_number'     => $checkRequestDuration['day_number'],
                    'status'         => 1
                ],
                [
                    'plan_id'        => $request->plan_id,
                    'duration'       => $request->duration,
                    'user_id'        => $user->id,
                    'meal_type_id'   => $recipe['meal_type_id'],
                    'recipe_id'      => $recipe['recipe_id'],
                    'start_date'     => $checkRequestDuration['start_date'],
                    'end_date'       => $checkRequestDuration['end_date'],
                    'day_number'     => $checkRequestDuration['day_number'],
                    'status'         => 1
                ]
            );
    }

}

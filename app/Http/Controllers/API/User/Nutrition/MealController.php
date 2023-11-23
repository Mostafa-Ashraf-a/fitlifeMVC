<?php

namespace App\Http\Controllers\API\User\Nutrition;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\User\Nutrition\CreateMealRequest;
use App\Http\Resources\User\Nutrition\UnderConstructions\BaseMealResource;
use App\Models\FoodExchange;
use App\Models\Meal;
use App\Models\UserMealPlan;
use App\Models\UserMealPlan as UserMealPlanModel;
use App\Services\API\User\Nutrition\MealService;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;

class MealController extends Controller
{
    use ApiResponse;
    private $service;

    const MEAL_ADDED_BY_CUSTOMER = 2;
    const  IN_PROGRESS           = 2;

    public function __construct(MealService $service)
    {
        \request()->headers->set('Accept', 'application/json');
        $this->service = $service;
    }

    public function index()
    {
        $meals =  UserMealPlan::query()
            ->with('underConstructionMeals.underConstructionFoodExchanges')
            ->where('user_id', auth()->guard('user-api')->user()->id)
            ->where('status', 1)
            ->where('plan_id', NULL)
            ->groupBy('meal_id')
            ->get();
        if ($meals->count() > 0) {
            return $this->success(" ", BaseMealResource::collection($meals));
        }
        return $this->success(__('api.You_do_not_have_any_plan_under_construction'), null);
    }

    #TODO Refactor this method
    public function store(CreateMealRequest $request)
    {
        $user = auth()->guard('user-api')->user();

        $checkIsRunning = UserMealPlanModel::where([
            'user_id' => $user->id,
            'status'  => self::IN_PROGRESS,
        ])->first();

        $checkSuggestedPlan = DB::table('user_suggested_plan')
            ->where('user_id', $user->id)
            ->whereIn('duration', [1, 2])
            ->where('status', '=', 1)
            ->first();

        if ($checkIsRunning || $checkSuggestedPlan) {
            return $this->coreResponse(__('api.you_already_have_a_running_plan'), 400, null, false);
        }

        $this->service->createUserMeal($request, $user);

        $meals =  UserMealPlan::query()
            ->with('underConstructionMeals.underConstructionFoodExchanges')
            ->where('user_id', $user->id)
            ->where('status', 1)
            ->where('plan_id', NULL)
            ->groupBy('meal_id')
            ->get();

        return $this->coreResponse(__('api.meal_plan_created_successfully'), 201, BaseMealResource::collection($meals), true);
    }

    public function show(Meal $meal)
    {
        $checkMeal = Meal::where('id', $meal->id)->where('is_default', self::MEAL_ADDED_BY_CUSTOMER)->first();

        if (!$checkMeal) {
            return $this->error("You don't have a right permission to access this meal!", 400);
        }

        $mealResponse =  UserMealPlan::query()
            ->with('underConstructionMeals.underConstructionFoodExchanges')
            ->where('user_id', auth()->guard('user-api')->user()->id)
            ->where('status', 1)
            ->where('plan_id', NULL)
            ->where('meal_id', $meal->id)
            ->first();
        if ($mealResponse) {
            return $this->success(" ", BaseMealResource::make($mealResponse));
        }
        return $this->error("The Meal isn't under construction!", 400);
    }

    public function update(CreateMealRequest $request, Meal $meal)
    {
        $checkMeal = Meal::where('id', $meal->id)->where('is_default', self::MEAL_ADDED_BY_CUSTOMER)->first();

        $checkMealStatus = UserMealPlan::where('meal_id', $meal->id)
            ->where('status', '!=', 1)
            ->first();

        if (!$checkMeal || $checkMealStatus) {
            return $this->error("You don't have a right permission to update this meal!", 400);
        }

        $user = auth()->guard('user-api')->user();

        $this->service->updateUserMeal($request, $user, $meal);

        $mealResponse =  UserMealPlan::query()
            ->with('underConstructionMeals.underConstructionFoodExchanges')
            ->where('user_id', auth()->guard('user-api')->user()->id)
            ->where('status', 1)
            ->where('plan_id', NULL)
            ->where('meal_id', $meal->id)
            ->first();

        return $this->success(" ", BaseMealResource::make($mealResponse));
    }

    public function destroy(Meal $meal)
    {
        $user = auth()->guard('user-api')->user();
        $checkMeal = Meal::where('id', $meal->id)->where('is_default', self::MEAL_ADDED_BY_CUSTOMER)->first();
        $checkMealStatus = UserMealPlan::where('meal_id', $meal->id)
            ->where('status', '!=', 1)
            ->first();
        if (!(request()->query('food_exchange_id'))) {
            return $this->error("Food exchange is required to proceed!", 400);
        }
        if (!$checkMeal || $checkMealStatus) {
            return $this->error("You don't have a right permission to update this meal!", 400);
        }
        $foodExchange = FoodExchange::findOrFail(request()->query('food_exchange_id'));
        $check = $this->service->deleteFoodExchange($user, $foodExchange, $meal);
        if ($check) {
            return $this->noContentResponse();
        }
        return $this->error("Food Exchange Already Deleted", 400);
    }
}

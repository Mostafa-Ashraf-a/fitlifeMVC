<?php

namespace App\Http\Controllers\API\User\Nutrition;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\User\Nutrition\PlanRequest;
use App\Http\Resources\User\Nutrition\MealPlan\PlanResource;
use App\Models\MealPlan;
use App\Models\UserMealPlan;
use App\Services\API\User\Nutrition\PlanService;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;

class PlanController extends Controller
{
    use ApiResponse;
    private $service;

    const PLAN_ADDED_BY_CUSTOMER = 2;
    const IN_PROGRESS_PLAN       = 2;

    public function __construct(PlanService $service)
    {
        \request()->headers->set('Accept', 'application/json');
        $this->service = $service;
    }

    public function index()
    {
        $plan =  UserMealPlan::query()
            ->with('plan.meals')
            ->where('user_id', auth()->guard('user-api')->user()->id)
            ->where('status', self::IN_PROGRESS_PLAN)
            ->groupBy('plan_id')
            ->first();

        if (isset($plan)) {
            return $this->success(" ", new PlanResource($plan->plan));
        }

        return $this->success(__('api.you_dont_have_running_plan'), null);
    }

    public function store(PlanRequest $request)
    {
        $user = auth()->guard('user-api')->user();

        $checkSuggestedPlan = DB::table('user_suggested_plan')
            ->where('user_id', $user->id)
            ->where('status', '=', 1)
            ->first();

        if ($checkSuggestedPlan) {
            return $this->coreResponse(__('api.you_already_have_a_running_plan'), 400, null, false);
        }

        $response = $this->service->store($request, $user);

        if ($response['status'] != 201) {
            return $this->coreResponse($response['message'], $response['status'], $response['data'], $response['isSuccess']);
        }

        $plan =  UserMealPlan::query()
            ->with('plan.meals')
            ->where('user_id', $user->id)
            ->where('status', self::IN_PROGRESS_PLAN)
            ->groupBy('plan_id')
            ->first();

        if (isset($plan)) {
            return $this->coreResponse(__('api.the_plan_has_been_successfully_launched'), $response['status'], new PlanResource($plan->plan), $response['isSuccess']);
        }

        return $this->error(__('api.oops_something_went_wrong'), 500);
    }

    public function update(PlanRequest $request, $id)
    {
        $user = auth()->guard('user-api')->user();

        $checkMeal = MealPlan::where('id', $id)->where('added_by', self::PLAN_ADDED_BY_CUSTOMER)->first();

        $mealPlan = UserMealPlan::where('user_id', $user->id)
            ->where('plan_id', $id)
            ->where('status', self::IN_PROGRESS_PLAN)
            ->first();

        if (!$checkMeal || !$mealPlan) {
            return $this->coreResponse("Resource Not Found!", 404, null, false);
        }

        $checkMeal->update([
            'title'  => $request->name
        ]);

        $plan =  UserMealPlan::query()
            ->with('plan.meals')
            ->where('user_id', $user->id)
            ->where('status', self::IN_PROGRESS_PLAN)
            ->groupBy('plan_id')
            ->first();

        if (isset($plan)) {
            return $this->coreResponse(__('api.meal_plan_updated_successfully'), 200, new PlanResource($plan->plan), true);
        }

        return $this->error("Oops! Something went wrong, Please try again later!", 500);
    }
}

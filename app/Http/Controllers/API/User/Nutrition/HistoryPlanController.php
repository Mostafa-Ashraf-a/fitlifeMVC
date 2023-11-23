<?php

namespace App\Http\Controllers\API\User\Nutrition;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\Nutrition\History\HistoryPlanResource;
use App\Http\Resources\User\Nutrition\History\SingleHistoryPlanResource;
use App\Http\Resources\User\Nutrition\History\Details\PlanResource as HistoryPlanDetailsResource;
use App\Models\MealPlan;
use App\Models\UserMealPlan;
use App\Services\API\User\Nutrition\ArchivePlanService;
use App\Services\API\User\Nutrition\HistoryPlanService;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryPlanController extends Controller
{
    use ApiResponse;

    private $service;
    const HISTORY_PLAN           = 3;
    const  IN_PROGRESS           = 2;
    const PLAN_ADDED_BY_CUSTOMER = 2;

    public function __construct(HistoryPlanService $service)
    {
        \request()->headers->set('Accept', 'application/json');
        $this->service = $service;
    }

    public function index()
    {
        $perPage = \request()->query('per_page') ?? 10;

        $historyPlans = UserMealPlan::query()
            ->with('historyPlans')
            ->where('user_id', auth()->guard('user-api')->user()->id)
            ->where('status', self::HISTORY_PLAN)
            ->groupBy('plan_id')
            ->orderByDesc('plan_id');

        $result = HistoryPlanResource::collection(
            $historyPlans->paginate($perPage)
                ->appends(['per_page' => $perPage])
        );

        return $this->responseWithPagination($result, $result->all(), $result->currentPage());
    }

    public function store(Request $request)
    {
        $archiveService = new ArchivePlanService();
        $service = $archiveService->archivePlan();
        if (!$service) {
            return $this->coreResponse(__('api.you_dont_have_running_plan'), 400, null, false);
        }
        return $this->coreResponse(__('api.the_plan_has_been_moved_to_your_history_successfully'), 200, true, true);
    }

    public function show($id)
    {
        $user = auth()->guard('user-api')->user();

        if ((int)\request()->query('type') == 2) {
            MealPlan::findOrFail($id);
            $plan = MealPlan::query()
                ->with('historyMealTypes.historySuggestedRecipes')
                ->where('id', $id)
                ->whereHas('historyMealTypes', function ($query) use ($id) {
                    $query->where('plan_id', $id)
                        ->where('status', 0)
                        ->where('duration', (int)\request()->query('duration'))
                        ->where('day_number', '=', (int)\request()->query('day_number'));
                })
                ->whereHas('historyMealTypes.historySuggestedRecipes', function ($query) use ($id) {
                    $query->where('plan_id', $id)
                        ->where('status', 0)
                        ->where('duration', (int)\request()->query('duration'))
                        ->where('day_number', '=', (int)\request()->query('day_number'));
                })
                ->first();
            if ($plan && ($plan->historyMealTypes->count() != 0)) {
                return $this->success(" ", HistoryPlanDetailsResource::make($plan));
            }
        }
        if ((int)\request()->query('type') == 1) {
            $checkMeal = MealPlan::where('id', $id)->where('added_by', self::PLAN_ADDED_BY_CUSTOMER)->first();
            $mealPlan = UserMealPlan::query()
                ->where('user_id', $user->id)
                ->where('plan_id', $id)
                ->where('status', self::HISTORY_PLAN)
                ->first();

            if (!$checkMeal || !$mealPlan) {
                return $this->coreResponse("Resource Not Found!", 404, null, false);
            }

            $historyPlan = UserMealPlan::query()
                ->with('historyPlans.historyMeals')
                ->where('user_id', $user->id)
                ->where('plan_id', $id)
                ->where('status', self::HISTORY_PLAN)
                ->groupBy('plan_id')
                ->first();
            return $this->success(" ", new SingleHistoryPlanResource($historyPlan));
        }
        return $this->success(" ", null);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type'          => 'required|integer|in:1,2',
            'duration'      => 'required_if:type,2|in:1,2',
            'day_number'    => 'required_if:type,2|in:0,1,2,3,4,5,6,7'
        ]);
        $user = auth()->guard('user-api')->user();
        if ($request->type != 2) {
            $checkMeal = MealPlan::where('id', $id)->where('added_by', self::PLAN_ADDED_BY_CUSTOMER)->first();
            $mealPlan = UserMealPlan::query()
                ->where('user_id', $user->id)
                ->where('plan_id', $id)
                ->where('status', self::HISTORY_PLAN)
                ->first();
            if (!$checkMeal || !$mealPlan) {
                return $this->coreResponse("Resource Not Found!", 404, null, false);
            }

            $this->service->resetPlanFromHistory($user, $id);
            $checkRunningMealPlan = UserMealPlan::query()
                ->where('user_id', $user->id)
                ->where('plan_id', $id)
                ->where('status', self::IN_PROGRESS)
                ->first();
            if ($checkRunningMealPlan) {
                return $this->success(__('api.plan_has_been_recovered_from_the_archives'), true);
            }
        } else {
            $mealPlan = UserMealPlan::query()
                ->where('user_id', $user->id)
                ->where('plan_id', $id)
                ->where('status', self::HISTORY_PLAN)
                ->where('type', $request->type)
                ->where('duration', $request->duration)
                ->where('day_number', $request->day_number)
                ->first();
            if (!$mealPlan) {
                return $this->coreResponse("Resource Not Found!", 404, null, false);
            }
            $this->service->moveSuggestedPlanToTheHistory($user);
            DB::transaction(function () use ($user, $id, $request, $mealPlan) {
                $mealPlan->delete();
                DB::table('user_suggested_plan')
                    ->where('user_id', $user->id)
                    ->where('status', 0)
                    ->where('plan_id', $id)
                    ->where('duration', $request->duration)
                    ->where('day_number', $request->day_number)
                    ->update([
                        'status'   => 1,
                        'start_date' => Carbon::now('Asia/Riyadh')->format('Y-m-d'),
                        'end_date'   => Carbon::now('Asia/Riyadh')->addDays(1)->format('Y-m-d'),
                    ]);
            }, 1);
            return $this->success(__('api.plan_has_been_reactivated'), true);
        }
    }
}

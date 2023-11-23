<?php

namespace App\Http\Controllers\API\User\Nutrition\SuggestedMealPlan;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\Nutrition\SubmittedPlan\PlanResource;
use App\Http\Resources\User\Nutrition\Suggested\Running\Daily\PlanResource as DailyRunningResource;
use App\Models\MealPlan;

use App\Services\API\User\Nutrition\SuggestedMealPlan\MealPlanService;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RunningPlanController extends Controller
{
    use ApiResponse;
    private $service;
    const WEEKLY_PLAN = 2;
    const ACTIVE_WEEKLY_PLAN = 1;
    public function __construct(MealPlanService $service)
    {
        \request()->headers->set('Accept','application/json');
        $this->service = $service;
    }

    public function index()
    {
        $now = Carbon::now('Asia/Riyadh')->format('Y-m-d');

        $plan = MealPlan::query()
            ->whereHas('dailyRunningMealTypes', function ($query) use($now) {
                $query->where('status','=',1)
                    ->whereDate('start_date','<=',$now)
                    ->whereDate('end_date','>=',$now);
            })->whereHas('dailyRunningMealTypes.dailyRunningSuggestedRecipes', function ($query) use($now){
                $query->where('status','=',1)
                    ->whereDate('start_date','<=',$now)
                    ->whereDate('end_date','>=',$now);
            })->first();


        if($plan && ($plan->dailyRunningMealTypes->count() != 0))
        {
            return $this->success(" ", DailyRunningResource::make($plan));
        }

        $yesterday = Carbon::yesterday('Asia/Riyadh')->format('Y-m-d');

        $getLastDailyRunningPlan = DB::table('user_suggested_plan')
            ->where('user_id',auth()->guard('user-api')->user()->id)
            ->where('duration', 1)
            ->where('status', self::ACTIVE_WEEKLY_PLAN)
            ->where('end_date', $yesterday)
            ->select('plan_id','duration','day_number')
            ->first();

        $getLastWeeklyRunningPlan = DB::table('user_suggested_plan')
            ->where('user_id',auth()->guard('user-api')->user()->id)
            ->where('duration', 2)
            ->where('status', self::ACTIVE_WEEKLY_PLAN)
            ->where('end_date', $yesterday)
            ->select('plan_id','duration','day_number')
            ->latest()
            ->first();

        if($getLastDailyRunningPlan)
        {
            $data = [
              'plan_id'     => $getLastDailyRunningPlan->plan_id,
              'duration'    => $getLastDailyRunningPlan->duration,
              'day_number'  => $getLastDailyRunningPlan->day_number,
              'question'    => __('api.do_you_want_to_use_the_previous_plan')
            ];
            return $this->success(" ", $data);
        }

        if($getLastWeeklyRunningPlan)
        {
            $data = [
                'plan_id'     => $getLastWeeklyRunningPlan->plan_id,
                'duration'    => $getLastWeeklyRunningPlan->duration,
                'day_number'  => $getLastWeeklyRunningPlan->day_number,
                'question'    => __('api.do_you_want_to_use_the_previous_plan')
            ];
            return $this->success(" ", $data);
        }

        return $this->success("it looks like you don't have a suggested running plan at the moment. Please create a new plan to get started",null);
    }

    public function show($planId)
    {
        MealPlan::findOrFail($planId);

        $plan = MealPlan::query()
            ->with('mealTypes.suggestedRecipes')
            ->where('id',$planId)
            ->whereHas('mealTypes', function ($query) use($planId){
                $query->where('plan_id', $planId)
                    ->where('status',1)
                    ->where('duration', 2)
                    ->where('day_number','=',\request()->query('day_number'));
            })
            ->whereHas('mealTypes.suggestedRecipes', function ($query) use($planId){
                $query->where('plan_id', $planId)
                    ->where('status',1)
                    ->where('duration', 2)
                    ->where('day_number','=',\request()->query('day_number'));
            })
            ->first();

        if($plan && ($plan->mealTypes->count() != 0))
        {
            return $this->success(" ", PlanResource::make($plan));
        }

        return $this->success(" ", null);
    }

    public function listWeeklyPlans()
    {
        $data = DB::table('user_suggested_plan')
            ->where('user_id',auth()->guard('user-api')->user()->id)
            ->where('duration', self::WEEKLY_PLAN)
            ->where('status', self::ACTIVE_WEEKLY_PLAN)
            ->groupBy('plan_id')
            ->orderBy('day_number','ASC')
            ->select('plan_id','day_number','start_date','end_date')
            ->get();

        return $this->success(" ", $data);
    }

    public function update(Request $request, $id)
    {
        if($request->duration == 1)
        {
            DB::table('user_suggested_plan')
                ->where('user_id',auth()->guard('user-api')->user()->id)
                ->where('duration', 1)
                ->where('status', 1)
                ->where('plan_id', $id)
                ->where('day_number', $request->day_number)
                ->update([
                    'start_date'  => Carbon::now('Asia/Riyadh')->format('Y-m-d'),
                    'end_date'    => Carbon::now('Asia/Riyadh')->addDays(1)->format('Y-m-d')
                ]);
            return $this->success(__('api.plan_has_been_reactivated'), true);
        }

        if($request->duration == 2)
        {
            $weekPlans = DB::table('user_suggested_plan')
                ->where('user_id',auth()->guard('user-api')->user()->id)
                ->where('duration', 2)
                ->where('status', 1)
                ->groupBy('plan_id')
                ->orderBy('day_number','ASC')
                ->select('plan_id','duration','day_number','start_date','end_date')
                ->get();

            $count = 0;

            foreach ($weekPlans as $plan)
            {
                DB::table('user_suggested_plan')
                    ->where('user_id',auth()->guard('user-api')->user()->id)
                    ->where('plan_id', $plan->plan_id)
                    ->where('day_number', $plan->day_number)
                    ->where('duration', 2)
                    ->where('status', 1)
                    ->update([
                        'start_date'  => Carbon::now('Asia/Riyadh')->addDays($count + 1)->format('Y-m-d'),
                        'end_date'    => Carbon::now('Asia/Riyadh')->addDays($count + 2)->format('Y-m-d')
                    ]);
                $count++;
            }

            return $this->success(__('api.plan_has_been_reactivated'), true);
        }
    }


}

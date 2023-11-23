<?php

namespace App\Http\Resources\User\Nutrition\Serving;

use App\Models\MealPlan;
use App\Models\Serving;
use App\Models\UserMealPlan;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class ServingResource extends JsonResource
{
    const HISTORY_PLAN            = 3;
    const PLAN_ADDED_BY_CUSTOMER  = 2;
    const  USED_SERVING           = 2;
    const IN_PROGRESS_PLAN        = 2;

    public function toArray($request)
    {
        $runningPlan = Serving::query()
            ->where('user_id', auth()->guard('user-api')->user()->id)
            ->where('status', self::USED_SERVING)
            ->where('plan_status', self::IN_PROGRESS_PLAN)
            ->first();
        if($request->query('history_plan_id'))
        {
            $historyPlanId = $request->query('history_plan_id');
            $checkMeal = MealPlan::where('id', $historyPlanId)->where('added_by',self::PLAN_ADDED_BY_CUSTOMER)->first();
            $mealPlan = UserMealPlan::query()
                ->where('user_id', auth()->guard('user-api')->user()->id)
                ->where('plan_id', $historyPlanId)
                ->where('status', self::HISTORY_PLAN)
                ->first();
            if($checkMeal && $mealPlan)
            {
                return [
                    'has_running_plan'            => $runningPlan ? true : false,
                    'master'                      => $this->whenLoaded('masterServing', MasterServingResource::make($this->masterServing)),
                    'used'                        => $this->whenLoaded('usedHistoryServing', UsedServingResource::make($this->usedHistoryServing)),
                    'under_implementation'        => $this->whenLoaded('underImplementationHistoryServing', UnderImplementationServingResource::make($this->underImplementationHistoryServing)),
                ];
            }
        }
        else{
            if($this->checkSuggestedPlan() != true)
            {
                return [
                    'has_running_plan'            => $runningPlan ? true : false,
                    'has_running_suggested'       => $this->checkSuggestedPlan(),
                    'has_expired_running_plan'    => $this->hasExpiredSuggestedPlan(),
                    'master'                      => $this->whenLoaded('masterServing', MasterServingResource::make($this->masterServing)),
                    'used'                        => $this->whenLoaded('usedServing', UsedServingResource::make($this->usedServing)),
                    'remaining'                   => $this->calculateRemaining($this->usedServing),
                    'under_implementation'        => $this->whenLoaded('underImplementationServing', UnderImplementationServingResource::make($this->underImplementationServing)),
                ];
            }else{
                return [
                    'has_running_plan'            => $runningPlan ? true : false,
                    'has_running_suggested'       => $this->checkSuggestedPlan(),
                    'has_expired_running_plan'    => $this->hasExpiredSuggestedPlan(),
                    'master'                      => $this->whenLoaded('masterServing', MasterServingResource::make($this->masterServing)),
                    'used'                        => $this->suggestedPlanServing(1),
                    'under_implementation'        => $this->suggestedPlanServing(2),
                ];
            }
        }
    }
    public function calculateRemaining($usedServing)
    {
        if(isset($usedServing))
        {
                return $remaining = [
                "id"         =>  $this->usedServing->id,
                "starches"   =>  $this->masterServing->starches - (integer)$this->usedServing->starches,
                "fruits"     =>  $this->masterServing->fruits - (integer)$this->usedServing->fruits,
                "vegetables" =>  $this->masterServing->vegetables - (integer)$this->usedServing->vegetables,
                "meats"      =>  $this->masterServing->meats - (integer)$this->usedServing->meats,
                "dairy"      =>  $this->masterServing->dairy - (integer)$this->usedServing->dairy,
                "oils"       =>  $this->masterServing->oils - (integer)$this->usedServing->oils
            ];
        }
        return null;
    }

    public function checkSuggestedPlan()
    {
        $now = Carbon::now('Asia/Riyadh')->format('Y-m-d');
        $limit = DB::table('user_suggested_plan')
            ->where('user_id', auth()->guard('user-api')->user()->id)
            ->whereDate('start_date','<=',$now)
            ->whereDate('end_date','>=',$now)
            ->where('status','=',1)
            ->first();
        if($limit)
        {
            return true;
        }
        return false;
    }

    public function suggestedPlanServing($status)
    {
        $now = Carbon::now('Asia/Riyadh')->format('Y-m-d');
        $limit = DB::table('user_suggested_plan')
            ->where('user_id', auth()->guard('user-api')->user()->id)
            ->whereDate('start_date','<=',$now)
            ->whereDate('end_date','>=',$now)
            ->where('status','=',1)
            ->first();
        if($limit)
        {
           $serving = DB::table('user_serving_per_food_type')
               ->where('user_id', auth()->guard('user-api')->user()->id)
               ->where('duration', $limit->duration)
               ->where('plan_id', $limit->plan_id)
               ->where('status', $status)
               ->where('day_number', $limit->day_number)
               ->first();
           return [
               'id'         => $serving->id,
               'plan_id'    => $serving->plan_id,
               'starches'   => $serving->Starches,
               'fruits'     => $serving->Fruits,
               'vegetables' => $serving->Vegetables,
               'meats'      => $serving->Meats,
               'dairy'      => $serving->Dairy,
               'oils'       => $serving->Oils,
           ];
        }
        return [];
    }

    public function hasExpiredSuggestedPlan() : bool
    {
        $yesterday = Carbon::yesterday('Asia/Riyadh')->format('Y-m-d');
        $getLastDailyRunningPlan = DB::table('user_suggested_plan')
            ->where('user_id',auth()->guard('user-api')->user()->id)
            ->where('duration', 1)
            ->where('status', 1)
            ->where('end_date', $yesterday)
            ->groupBy('plan_id')
            ->orderByDesc('id')
            ->first();

        $getLastWeeklyRunningPlan = DB::table('user_suggested_plan')
            ->where('user_id',auth()->guard('user-api')->user()->id)
            ->where('duration', 2)
            ->where('status', 1)
            ->where('end_date', $yesterday)
            ->groupBy('plan_id')
            ->orderByDesc('id')
            ->first();
        if($getLastDailyRunningPlan || $getLastWeeklyRunningPlan)
        {
            return true;
        }else{
            return false;
        }
    }
}

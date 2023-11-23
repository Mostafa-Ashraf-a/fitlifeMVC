<?php


namespace App\Services\API\User\Nutrition;


use App\Models\UserMealPlan;
use App\Models\UserMealPlan as UserMealPlanModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArchivePlanService
{
    const  IN_PROGRESS = 2;
    const HISTORY_PLAN = 3;
    private $user;

    public function __construct()
    {
        $this->user = Auth::guard('user-api')->user();
    }

    public function archivePlan() : bool
    {
        $customPlan    = $this->customPlan();
        $suggestedPlan = $this->suggestedPlan();
        if($customPlan || $suggestedPlan)
        {
            return true;
        }
        return false;
    }

    private function customPlan() : bool
    {
        $result = false;
        $historyPlanService = new HistoryPlanService();
        $customPlan = UserMealPlan::query()
            ->where('user_id', $this->user->id)
            ->where('status', self::IN_PROGRESS)
            ->first();
        if($customPlan)
        {
            $result = $historyPlanService->movingRunningPlanToHistory($this->user, $customPlan->plan_id);
        }
        return $result;
    }

    private function suggestedPlan() : bool
    {
        $result = false;
        $suggestedPlans = DB::table('user_suggested_plan')
            ->where('user_id',$this->user->id)
            ->whereIN('duration', [1,2])
            ->where('status', 1)
            ->select('plan_id','day_number','start_date','duration','user_id')
            ->get();
        if(count($suggestedPlans) > 0)
        {
            foreach ($suggestedPlans as $plan)
            {
                DB::transaction(function () use($plan) {
                    UserMealPlanModel::updateOrCreate(
                        [
                            'user_id'     => $this->user->id,
                            'plan_id'     => $plan->plan_id,
                            'status'      => self::HISTORY_PLAN,
                            'type'        => 2,
                            'duration'    => $plan->duration,
                            'day_number'  => $plan->day_number
                        ],
                        [
                            'user_id'     => $this->user->id,
                            'plan_id'     => $plan->plan_id,
                            'status'      => self::HISTORY_PLAN,
                            'type'        => 2,
                            'duration'    => $plan->duration,
                            'day_number'  => $plan->day_number,
                            'start_date'  => $plan->start_date,
                            'end_date'    => Carbon::now('Asia/Riyadh')->format('Y-m-d'),
                        ]
                    );

                    DB::table('user_suggested_plan')
                        ->where('user_id',$this->user->id)
                        ->where('plan_id', $plan->plan_id)
                        ->where('duration', $plan->duration)
                        ->where('day_number', $plan->day_number)
                        ->where('status', 1)
                        ->update([
                            'status'    => 0
                        ]);
                });
            }
            $result = true;
        }
        return $result;
    }

}

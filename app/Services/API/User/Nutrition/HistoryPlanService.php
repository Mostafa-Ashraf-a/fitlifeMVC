<?php


namespace App\Services\API\User\Nutrition;


use App\Models\Serving;
use App\Models\UserMealPlan as UserMealPlanModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HistoryPlanService
{
    const HISTORY_PLAN          = 3;
    const IN_PROGRESS_PLAN      = 2;

    public function createHistoryPlanFromSuggested($user, $planId, $startDate, $duration, $dayNumber) : bool
    {
        UserMealPlanModel::updateOrCreate(
            [
                'user_id'     => $user->id,
                'plan_id'     => $planId,
                'status'      => self::HISTORY_PLAN,
                'type'        => 2,
                'duration'    => $duration,
                'day_number'  => $dayNumber
            ],
            [
                'user_id'     => $user->id,
                'plan_id'     => $planId,
                'status'      => self::HISTORY_PLAN,
                'type'        => 2,
                'duration'    => $duration,
                'day_number'  => $dayNumber,
                'start_date'    => $startDate,
                'end_date'    => Carbon::now('Asia/Riyadh')->format('Y-m-d'),
            ]
        );
        return true;
    }
    public function movingRunningPlanToHistory($user, $planId) : bool
    {
        if($this->updateServing($user, self::IN_PROGRESS_PLAN, self::HISTORY_PLAN))
        {
            return UserMealPlanModel::query()
                ->where('user_id', $user->id)
                ->where('plan_id',$planId)
                ->where('status', self::IN_PROGRESS_PLAN)
                ->update([
                    'status'       => self::HISTORY_PLAN,
                    'type'         => 1,
                    'end_date' => Carbon::now('Asia/Riyadh')->format('Y-m-d')
                ]);
        }
        return false;
    }

    public function moveSuggestedPlanToTheHistory($user) : bool
    {
        $plans = DB::table('user_suggested_plan')
            ->where('user_id',$user->id)
            ->whereIN('duration', [1,2])
            ->where('status', 1)
            ->groupBy('plan_id')
            ->orderBy('day_number','ASC')
            ->select('plan_id','day_number','start_date','duration')
            ->get();
        if(count($plans) > 0)
        {
            foreach ($plans as $plan)
            {
                UserMealPlanModel::updateOrCreate(
                    [
                        'user_id'     => $user->id,
                        'plan_id'     => $plan->plan_id,
                        'status'      => self::HISTORY_PLAN,
                        'type'        => 2,
                        'duration'    => $plan->duration,
                        'day_number'  => $plan->day_number
                    ],
                    [
                        'user_id'     => $user->id,
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
                    ->where('user_id',$user->id)
                    ->where('plan_id', $plan->plan_id)
                    ->where('duration', $plan->duration)
                    ->where('day_number', $plan->day_number)
                    ->where('status', 1)
                    ->update([
                        'status'    => 0
                    ]);
            }
        }
        return true;
    }

    public function resetPlanFromHistory($user, $planId)
    {
        DB::transaction(function () use($user, $planId) {
            UserMealPlanModel::query()
                ->where('user_id', $user->id)
                ->where('status', self::IN_PROGRESS_PLAN)
                ->update([
                    'status'   => self::HISTORY_PLAN,
                    'end_date' => Carbon::now('Asia/Riyadh')->format('Y-m-d')
                ]);

            UserMealPlanModel::query()
                ->where('user_id', $user->id)
                ->where('plan_id', $planId)
                ->where('status', self::HISTORY_PLAN)
                ->update([
                    'status'     => self::IN_PROGRESS_PLAN,
                    'start_date' => Carbon::now('Asia/Riyadh')->format('Y-m-d'),
                    'end_date'   => NULL
                ]);

            Serving::where('user_id', $user->id)
                ->where('plan_status',self::IN_PROGRESS_PLAN)
                ->update([
                    'plan_status'   => self::HISTORY_PLAN,
                ]);

            Serving::where('user_id', $user->id)
                ->where('plan_status',self::HISTORY_PLAN)
                ->where('plan_id', $planId)
                ->update([
                    'plan_status'   => self::IN_PROGRESS_PLAN,
                ]);
        }, 1);
    }

    private function updateServing($user, $inProgressPlanStatus = null, $historyPlanStatus = null) : bool
    {
        return Serving::where('user_id', $user->id)
            ->where('plan_status',$inProgressPlanStatus)
            ->update([
                'plan_status'   => $historyPlanStatus,
            ]);
    }
}

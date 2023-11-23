<?php


namespace App\Services\API\User\Nutrition;


use App\Models\MealPlan as PlanModel;
use App\Models\Serving;
use App\Models\UserMealPlan as UserMealPlanModel;
use Carbon\Carbon;

class PlanService
{
    const  UNDER_CONSTRUCTION    = 1;
    const  IN_PROGRESS           = 2;
    const UNDER_IMPLEMENTATION   = 3;
    const PLAN_ADDED_BY_CUSTOMER = 2;
    const USED_SERVING           = 2;

    public function store($request, $user)
    {
        $planStatus = $this->checkUserPlan($user);

        if($planStatus == 1)
        {
            $plan = $this->createPlan($request, $user);

            if($plan){
                return $response = [
                    'message'   => " ",
                    'status'    => 201,
                    'data'      => null,
                    'isSuccess' => true
                ];
            }
        }
        elseif ($planStatus == 2 )
        {
            return $response = [
                'message'   => __('api.you_already_have_a_running_plan'),
                'status'    => 400,
                'data'      => null,
                'isSuccess' => false
            ];
        }
        else
        {
            return $response = [
                'message'   => __('api.you_dont_have_active_meals'),
                'status'    => 400,
                'data'      => null,
                'isSuccess' => false
            ];
        }
    }

    private function checkUserPlan($user)
    {
        $planStatus = 1;

        $underConstructionPlan = UserMealPlanModel::where(
            [
                'user_id'          => $user->id,
                'status'           => self::UNDER_CONSTRUCTION,
            ]
        )->first();

        if($underConstructionPlan)
        {
            return $planStatus;
        }

        $inProgressPlan = UserMealPlanModel::where(
            [
                'user_id'          => $user->id,
                'status'           => self::IN_PROGRESS,
            ]
        )->first();

        if($inProgressPlan){
            return $planStatus = 2;
        }

        return $planStatus = 3;
    }

    private function createPlan($request, $user)
    {
        $plan = PlanModel::create([
            'title'     => $request->name,
            'added_by'  => self::PLAN_ADDED_BY_CUSTOMER,
        ]);

        UserMealPlanModel::query()
            ->where('user_id', $user->id)
            ->where('status', self::UNDER_CONSTRUCTION)
            ->update([
                'status'     => self::IN_PROGRESS,
                'plan_id'    => $plan->id,
                'start_date' => Carbon::now('Asia/Riyadh')->format('Y-m-d')
            ]);

        Serving::updateOrCreate(
            [
                'user_id'           => $user->id,
                'status'            => self::UNDER_IMPLEMENTATION,
                'plan_id'           => $plan->id,
                'plan_status'       => self::IN_PROGRESS
            ],
            [
                'user_id'           => $user->id,
                'plan_id'           => $plan->id,
                'status'            => self::UNDER_IMPLEMENTATION,
                'plan_status'   => self::IN_PROGRESS,
                'starches'      => 0,
                'fruits'        => 0,
                'vegetables'    => 0,
                'meats'         => 0,
                'dairy'         => 0,
                'oils'          => 0,
            ]
        );

        Serving::query()
            ->where('user_id', $user->id)
            ->where('status', self::USED_SERVING)
            ->where('plan_id', NULL)
            ->where('plan_status', self::UNDER_CONSTRUCTION)
            ->update([
                'plan_id'       => $plan->id,
                'plan_status'   => self::IN_PROGRESS,
            ]);

        return $plan;
    }
}

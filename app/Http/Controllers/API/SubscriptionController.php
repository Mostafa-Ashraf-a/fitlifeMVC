<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\SubscriptionRequest;
use App\Http\Resources\SubscriptionResource;
use App\Models\Coupon;
use App\Models\PlanManagement;
use App\Models\Subscription;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        \request()->headers->set('Accept','application/json');
    }

    public function index()
    {
        $plan = Subscription::query()
            ->with(['plan'])
            ->where('user_id', auth()->guard('user-api')->user()->id)
            ->where('status',1)
            ->latest()
            ->first();

        if($plan != null){
            return $this->success(" ", SubscriptionResource::make($plan));
        }

        return $this->success(" ", null);
    }

    public function store(SubscriptionRequest $request)
    {
        $userId = auth()->guard('user-api')->user()->id;
        $plan = PlanManagement::findOrFail($request->plan_management_id);
        $currentDay = Carbon::now('Asia/Riyadh')->format('Y-m-d');
        $coupon = Coupon::query()
            ->where('code',$request->coupon_code)
            ->where('end_date', '>', $currentDay)
            ->where('status',true)
            ->first();
        if(isset($request->coupon_code) && (!$coupon) || (isset($coupon) && ($coupon->usage_limit == $coupon->usage)))
        {
            return $this->coreResponse(__('api.The_discount_voucher_is_not_valid'), 400,null,false);
        }
        if($plan->plan_duration_id == 1)
        {
            Subscription::create([
                'user_id'              => $userId,
                'plan_management_id'   => $plan->id,
                'status'               => 1
            ]);
        }
        else{
            if($plan->trail_period != 0)
            {
                Subscription::create([
                    'user_id'              => $userId,
                    'plan_management_id'   => $plan->id,
                    'free_trail_start'     => Carbon::now('Asia/Riyadh')->format('Y-m-d H:i:s'),
                    'free_trail_end'       => Carbon::now('Asia/Riyadh')->addDays($plan->trail_period)->format('Y-m-d H:i:s'),
                    'card_brand'           => $request->card_brand,
                    'card_first_six'       => $request->card_first_six,
                    'status'               => $request->status,
                    'is_free'              => 0,
                ]);
            }else{
                $expired_at = null;
                if($plan->plan_duration_id == 2)
                {
                    $expired_at = Carbon::now('Asia/Riyadh')->addWeek()->format('Y-m-d H:i:s');
                }
                if($plan->plan_duration_id == 3)
                {
                    $expired_at = Carbon::now('Asia/Riyadh')->addMonth()->format('Y-m-d H:i:s');
                }
                if($plan->plan_duration_id == 4)
                {
                    $expired_at = Carbon::now('Asia/Riyadh')->addYear()->format('Y-m-d H:i:s');
                }
                if($plan->plan_duration_id == 5)
                {
                    $expired_at = Carbon::now('Asia/Riyadh')->addQuarters(1)->format('Y-m-d H:i:s');
                }
                if($plan->plan_duration_id == 6)
                {
                    $expired_at = Carbon::now('Asia/Riyadh')->addQuarters(2)->format('Y-m-d H:i:s');
                }
                Subscription::create([
                    'user_id'               => $userId,
                    'plan_management_id'    => $plan->id,
                    'subscribed_at'         => Carbon::now('Asia/Riyadh')->format('Y-m-d H:i:s'),
                    'expired_at'            => $expired_at,
                    'transaction_number'    => $request->transaction_number,
                    'status'                => $request->status,
                    'is_free'               => 0,
                    'coupon_id'             => $coupon->id ?? null,
                    'coupon_code'           => $coupon->code ?? null,
                    'coupon_discount_type'  => $coupon->discount_type ?? null,
                    'coupon_discount_value' => $coupon->discount_value ?? null,
                ]);
                if($coupon)
                {
                    $coupon->increment('usage');
                }
            }
        }
        return $this->success(" ",true);
    }
}

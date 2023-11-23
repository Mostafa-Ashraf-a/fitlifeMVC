<?php

namespace App\Http\Controllers\API\User\Subscription;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\User\Subscription\InvoiceRequest;
use App\Http\Resources\User\Subscription\InvoiceResource;
use App\Models\Coupon;
use App\Models\PlanManagement;
use App\Models\Subscription;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    use ApiResponse;
    const FIXED_COUPON = 1;
    const PERCENTAGE_COUPON = 2;
    public function store(InvoiceRequest $request)
    {
        $currentDay = Carbon::now('Asia/Riyadh')->format('Y-m-d');
        $plan = PlanManagement::findOrFail($request->plan_id);
        $checkCoupon = Coupon::query()
            ->where('code',$request->coupon_code)
            ->where('end_date', '>', $currentDay)
            ->where('status',true)
            ->first();
        if(($checkCoupon && ($checkCoupon->usage_limit > $checkCoupon->usage)) && (isset($plan) && $plan->plan_duration_id != 1))
        {
            $data = [
                'plan_id'   => $plan->id,
                'plan_name' => $plan->plan_name,
                'price'     => $plan->price,
                'invoice'   => [
                    [
                        'code'             => 'sub_totals',
                        'value'            => $plan->price,
                        'value_string'     => (string)$plan->price . ' ' . $plan->currency,
                        'currency'         => $plan->currency,
                        'title'            => __('api.package_amount')
                    ],
                    [
                        'code'             => 'coupon',
                        'value'            => - $this->calculateCoupon($checkCoupon, $plan->price),
                        'value_string'     => (string) - $this->calculateCoupon($checkCoupon, $plan->price) . ' ' . $plan->currency,
                        'currency'         => $plan->currency,
                        'title'            => __('api.coupon')
                    ],
                    [
                        'code'             => 'sub_totals_after_coupon_discount',
                        'value'            => $plan->price - $this->calculateCoupon($checkCoupon, $plan->price),
                        'value_string'     => (string) $plan->price - $this->calculateCoupon($checkCoupon, $plan->price) . ' ' . $plan->currency,
                        'currency'         => $plan->currency,
                        'title'            => __('api.sub_totals_after_coupon_discount')
                    ],[
                        'code'             => 'total',
                        'value'            => $plan->price - $this->calculateCoupon($checkCoupon, $plan->price),
                        'value_string'     => (string) $plan->price - $this->calculateCoupon($checkCoupon, $plan->price) . ' ' . $plan->currency,
                        'currency'         => $plan->currency,
                        'title'            => __('api.total')
                    ]
                ]
            ];
            return $this->coreResponse(" ", 200,$data,true);
        }
        elseif (empty($request->coupon_code) && (isset($plan) && $plan->plan_duration_id != 1))
        {
            $data = [
                'plan_id'   => $plan->id,
                'plan_name' => $plan->plan_name,
                'price'     => $plan->price,
                'invoice'   => [
                        'code'             => 'total',
                        'value'            => $plan->price,
                        'value_string'     => (string) $plan->price,
                        'currency'         => $plan->currency,
                        'title'            => __('api.total')
                ]
            ];
            return $this->coreResponse(" ", 200,$data,true);
        }
        elseif (empty($request->coupon_code) && (isset($plan) && $plan->plan_duration_id == 1))
        {
            $data = [
                'plan_id'   => $plan->id,
                'plan_name' => $plan->plan_name,
                'price'     => $plan->price,
                'invoice'   => null
            ];
            return $this->coreResponse(" ", 200,$data,true);
        }
        else{
            return $this->coreResponse(__('api.The_discount_voucher_is_not_valid'), 400,null,false);
        }
    }

    public function calculateCoupon($coupon, $planPrice)
    {
        if($coupon->discount_type == self::PERCENTAGE_COUPON)
        {
            return $amount = ($coupon->discount_value / 100) * $planPrice;
        }
        $amount = $coupon->discount_value;
        return $amount;
    }
}

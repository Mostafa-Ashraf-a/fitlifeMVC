<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable = [
      'user_id',
      'plan_management_id',
      'subscribed_at',
      'expired_at',
      'free_trail_start',
      'free_trail_end',
      'transaction_number',
      'is_free',
      'card_brand',
      'card_first_six',
      'status',
      'coupon_id',
      'coupon_code',
      'coupon_discount_type',
      'coupon_discount_value',
    ];


    public function plan() : BelongsTo
    {
        return $this->belongsTo(PlanManagement::class, 'plan_management_id');
        //Hello World
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function scopeCheckIsExpire($subscriptionId) : bool
    {
        $now = Carbon::now('Asia/Riyadh')->format('Y-m-d H:i:s');
        $status = false;
        $subscription = Subscription::find($subscriptionId);

        if(isset($subscription) && isset($subscription->expired_at))
        {
            if($subscription->expired_at < $now){
                $status = true;
            }
        }
        return $status;
    }

    public function scopeCheckIsExpireTrail($subscriptionId) : bool
    {
        $now = Carbon::now('Asia/Riyadh')->format('Y-m-d H:i:s');
        $status = false;
        $subscription = Subscription::find($subscriptionId);

        if(isset($subscription) && isset($subscription->free_trail_end))
        {
            if($subscription->free_trail_end < $now){
                $status = true;
            }
        }
        return $status;
    }

    public function scopeCheckIsPaid($subscriptionId) : bool
    {
        $status = false;
        $subscription = Subscription::find($subscriptionId);

        if(isset($subscription) && ($subscription->is_free == 0) && ($subscription->plan->trail_period == 0))
        {
            $status = true;
        }
        return $status;
    }

    public function scopeCheckIsTrailPeriod($subscriptionId) : bool
    {
        $status = false;
        $subscription = Subscription::find($subscriptionId);

        if(isset($subscription) && ($subscription->plan->trail_period > 0))
        {
            $status = true;
        }
        return $status;
    }

    public function scopeCheckIsFree($subscriptionId) : bool
    {
        $status = false;
        $subscription = Subscription::find($subscriptionId);

        if(isset($subscription) && ($subscription->is_free == 1))
        {
            $status = true;
        }
        return $status;
    }
}

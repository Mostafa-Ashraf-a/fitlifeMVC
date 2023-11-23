<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{

    public function toArray($request)
    {
        #TODO check if the is_expired is working for all cases and plan types
        return [
            'id'                  => $this->id,

            'is_free'             => $this->scopeCheckIsFree($this->id),
            'is_trail_period'     => $this->scopeCheckIsTrailPeriod($this->id),
            'is_paid'             => $this->scopeCheckIsPaid($this->id),

            'subscribed_at'       => $this->subscribed_at,
            'expired_at'          => $this->expired_at,

            'is_expire'           => $this->scopeCheckIsExpire($this->id),
            'is_expire_trail'     => $this->scopeCheckIsExpireTrail($this->id),

            'free_trail_start'    => $this->free_trail_start,
            'free_trail_end'      => $this->free_trail_end,

            'plan'                => $this->whenLoaded('plan',PlanResource::make($this->plan))
        ];
    }
}

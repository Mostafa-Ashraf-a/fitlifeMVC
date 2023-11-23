<?php

namespace App\Http\Resources\User\Subscription;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'plan_name' => $this->plan_name
        ];
    }
}

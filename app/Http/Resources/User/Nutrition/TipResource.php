<?php

namespace App\Http\Resources\User\Nutrition;

use Illuminate\Http\Resources\Json\JsonResource;

class TipResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'title'     => $this->title,
            'content'   => $this->content,
        ];
    }
}

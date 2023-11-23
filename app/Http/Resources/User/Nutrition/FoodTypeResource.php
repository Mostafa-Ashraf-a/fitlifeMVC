<?php

namespace App\Http\Resources\User\Nutrition;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FoodTypeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'title'      => $this->title,
            'image'      => $this->image ? url(Storage::url('files/foodTypes/images/' . $this->id . '/thumb-' . $this->image)) : null,
        ];
    }
}

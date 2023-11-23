<?php

namespace App\Http\Resources\User\UserInformation;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id"                 => $this->id,
            "full_name"          => $this->full_name,
            "email"              => $this->email,
            "mobile"             => $this->mobile,
            "age"                => $this->age,
            "gender"             => $this->gender,
            'image'              => $this->image ? url(Storage::url('files/users/images/' . $this->id . '/thumb-' . $this->image)) : null,
            "goal"               => $this->goal,
            "level"              => $this->level,
            "weight"             => $this->weight,
            "height"             => $this->height,
            "serving_reset_time" => $this->serving_reset_time,
            "created_at"         => $this->created_at,
            "updated_at"         => $this->updated_at,
        ];
    }
}

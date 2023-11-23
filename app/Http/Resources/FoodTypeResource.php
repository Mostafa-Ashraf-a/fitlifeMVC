<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FoodTypeResource extends JsonResource
{
    public static $mode = 'foodTypes';

    /**
     * set the current mode for this resource
     * @param $mode
     * @return string
     */
    public static function setMode($mode) : string
    {
        self::$mode = $mode;
        return __CLASS__;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'title'     => $this->title,
            'image'     => $this->image ? url(Storage::url('files/foodTypes/images/' . $this->id . '/thumb-' . $this->image)) : null,
        ];
    }
}

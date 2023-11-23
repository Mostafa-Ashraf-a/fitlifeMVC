<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FoodExchange extends JsonResource
{
    public static $mode = 'food-exchange';

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
//            'id'                        => $this->id,
//            'title'                     => $this->title,
//            'measurementUnits'          => $this->whenLoaded('measurementUnits',$this->measurementUnits),
//            'image_url'                 => $this->image_url,
//            'created_at'                => $this->created_at,
            'id'                        => $this->id,
            'title'                     => $this->title,
            'image'                     => $this->image,
            'image_url'                 => asset('/') . 'assets/images/foodExchanges/' . $this->image,
            'measurementUnits'          => $this->whenLoaded('mUnits',MeasurementUnitResource::collection($this->mUnits)),
            'created_at'                => $this->created_at,
        ];
    }
}

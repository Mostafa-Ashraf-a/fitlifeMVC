<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryTypeResource extends JsonResource
{
    public static $mode = 'category-types';

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
            'id'                        => $this->id,
            'name'                      => $this->name,
        ];
    }
}

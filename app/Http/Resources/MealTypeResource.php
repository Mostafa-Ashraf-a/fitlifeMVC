<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class MealTypeResource extends JsonResource
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
            'id'                 => $this->id,
            'title'              => $this->title,
            'food_exchanges'     => $this->whenLoaded('foodExchanges',FoodExchange::collection($this->foodExchanges)) ?? null
        ];
    }
}

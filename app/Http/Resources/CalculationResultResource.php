<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CalculationResultResource extends JsonResource
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
            'user_id'              => $this->id,
            'user_name'            => $this->full_name,
            'age'                  => $this->age,
            'gender'               => $this->gender,
            'weight'               => $this->weight,
            'height'               => $this->height,
            'goal'                 => $this->goal,
            'question_answers'     => $this->whenLoaded('calculationResult',QuestionAnswersResultResource::collection($this->calculationResult)),
            'calculation_result'   => $this->whenLoaded('userBodyMassIndex',QuestionResultResource::make($this->userBodyMassIndex)),
        ];
    }
}

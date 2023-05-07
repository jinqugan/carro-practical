<?php

namespace App\Http\Resources\Survey;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\ResourceTrait;

class SurveyQuestionResource extends JsonResource
{
    use ResourceTrait;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (empty($this->resource)) {
            return null;
        }

        return [
            'id' => $this->id,
            'question' => $this->question,
            'type' => $this->type,
        ];
    }
}

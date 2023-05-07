<?php

namespace App\Http\Resources\Survey;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\ResourceTrait;

class SurveyOptionResource extends JsonResource
{
    // use ResourceTrait;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'option' => $this->option,
        ];
    }
}

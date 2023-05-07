<?php

namespace App\Http\Resources\Survey;

use App\Http\Resources\PaginateResource;
use App\Traits\CollectionTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SurveyOptionCollection extends ResourceCollection
{
    use CollectionTrait;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection;
    }
}

<?php

namespace App\Http\Resources\Survey;

use App\Models\SurveyQuestion;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\ResourceTrait;

class SurveyResource extends JsonResource
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
            'survey' => [
                'id' => $this->id,
                'title' => $this->title,
                'active' => $this->active,
                'created_at' => $this->created_at,
            ],
            'survey_questions' => (new SurveyQuestionCollection($this->surveyQuestions)),
        ];
    }
}

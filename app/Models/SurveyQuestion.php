<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends BaseModel
{
    use  HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'survey_id',
        'question',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        //
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function surveyOptions()
    {
        return $this->hasMany(SurveyOption::class);
    }

    public function surveyResponses()
    {
        return $this->hasMany(SurveyResponse::class);
    }

    public function surveyResponsesWithAnswers()
    {
        return $this->surveyResponses()->with(['surveyAnswers' => function ($query) {
            $query->where('survey_question_id', $this->id);
        }]);
    }
}

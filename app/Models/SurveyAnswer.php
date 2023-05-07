<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends BaseModel
{
    use  HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'survey_response_id',
        'survey_question_id',
        'answer',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>how
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

    public function surveyQuestion()
    {
        return $this->belongsTo(SurveyQuestion::class);
    }

    public function surveyResponse()
    {
        return $this->belongsTo(SurveyResponse::class);
    }
}

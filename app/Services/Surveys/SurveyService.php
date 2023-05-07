<?php

namespace App\Services\Surveys;

use App\Interfaces\CalculatorInterface;
use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\Models\SurveyOption;
use App\Models\SurveyQuestion;
use App\Models\SurveyResponse;
use App\Traits\SurveyTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SurveyService implements SurveyServiceInterface
{
    use SurveyTrait;

    public function createForm(array $userData): Survey
    {
        $createdAt = Carbon::now();

        /** @var Survey $survey */
        $survey = Survey::create([
            'title' => $userData['title'],
            'active' => $userData['publish'],
        ]);

        $questions = array_merge(array_values($this->defaultInputs($userData['default_questions'] ?? [])), $userData['questions']);

        $surveyQuestions = [];
        $surveyOptions = [];

        foreach ($questions as $key => $question) {
            $surveyQuestions[] = [
                'survey_id' => $survey['id'],
                'question' => $question['name'],
                'type' => $question['type'],
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];
        }

        if (!empty($surveyQuestions)) {
            SurveyQuestion::insert($surveyQuestions);
            $questionIds = SurveyQuestion::select('id')->where('survey_id', $survey['id'])->pluck('id');

            foreach ($questions as $key => $question) {
                if (!empty($question['options'])) {
                    foreach ($question['options'] as $option) {
                        $surveyOptions[] = [
                            'survey_question_id' => $questionIds[$key],
                            'option' => $option,
                            'created_at' => $createdAt,
                            'updated_at' => $createdAt,
                        ];
                    }
                }
            }

            if (!empty($surveyOptions)) {
                SurveyOption::insert($surveyOptions);
            }
        }

        return $survey;
    }

    public function updateForm(Survey $survey, array $formData)
    {
    }

    public function deleteForm(Survey $user)
    {
    }

    public function getForm(int $formId): ?Survey
    {
        if ($formId == 0) {
            return Survey::inRandomOrder()->first();
        }

        return Survey::find($formId);
    }

    public function getForms(): iterable
    {
        return Survey::paginate(20);
    }

    public function answerForm(array $surveyData): void
    {
        $createdAt = Carbon::now();
        $surveyResponseId = SurveyResponse::insertGetId([
            'survey_id' => $surveyData['survey_id'],
            'user_id' => Auth()->id(),
        ]);

        $surveyAnswers = [];

        foreach ($surveyData['answers'] as $key => $answer) {
            $surveyAnswers[] = [
                'survey_response_id' => $surveyResponseId,
                'survey_question_id' => $answer['survey_question_id'],
                'answer' => $answer['answer'],
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];
        }

        if (!empty($surveyAnswers)) {
            SurveyAnswer::insert($surveyAnswers);
        }
    }
}

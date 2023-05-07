<?php

namespace App\Http\Requests\Survey;

use App\Http\Requests\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Traits\SurveyTrait;
use Illuminate\Validation\Rule;

class SurveyAnswerRequest extends FormRequest
{
    use SurveyTrait;

    public function __construct()
    {
        //
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $inputs = ($this->defaultInputs());

        return [
            'survey_id' => 'required|integer|exists:surveys,id',
            'answers' => 'required|array|min:1',
            'answers.*.survey_question_id' => 'required|integer|exists:survey_questions,id',
            'answers.*.answer' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'answers.*.answer.required' => 'The answer is required.',
        ];
    }
}

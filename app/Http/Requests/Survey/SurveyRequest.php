<?php

namespace App\Http\Requests\Survey;

use App\Http\Requests\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Traits\SurveyTrait;
use Illuminate\Validation\Rule;

class SurveyRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'publish' => 'sometimes|boolean',
            'default_questions' => ['nullable', 'array', Rule::in(array_keys($inputs))],
            'questions' => 'required|array|min:1',
            'questions.*.name' => 'required|string',
            'questions.*.type' => ['required', Rule::in(array_column($inputs, 'type'))],
        ];
    }

    public function messages()
    {
        return [
            //
        ];
    }
}

<?php

namespace App\Services\Surveys;

use App\Models\Survey;

interface SurveyServiceInterface
{
    public function createForm(array $surveyData): Survey;

    public function updateForm(Survey $survey, array $formData);

    public function deleteForm(Survey $survey);

    public function getForm(int $formId): ?Survey;

    public function getForms(): iterable;

    public function answerForm(array $surveyData): void;
}

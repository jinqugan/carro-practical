<?php

namespace App\Traits;

use Illuminate\Support\Arr;

trait SurveyTrait
{
    public function defaultInputs(array $selected = ['*'], array $attributes = []): array
    {
        $defaults = [
            'name' => $attributes + [
                'name' => 'Name',
                'type' => 'text',
            ],
            'phone' => $attributes + [
                'name' => 'Phone Number',
                'type' => 'number',
            ],
            'birth_date' => $attributes + [
                'name' => 'Date of Birth',
                'type' => 'date',
            ],
        ];


        if (in_array('*', $selected)) {
            return $defaults;
        }

        return Arr::only($defaults, $selected);
    }
}

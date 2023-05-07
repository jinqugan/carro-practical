<?php

/**
 * Request : FormRequest.
 *
 * This file used for FormRequest to handle api request validation with json error
 */

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest as CustomFormRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ResponseTrait;

abstract class FormRequest extends CustomFormRequest
{
    use ResponseTrait;

    protected $responseErrors;
    protected $exceptionError;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    abstract public function authorize();

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $result = [];
        $errors = [];
        $responses = null;
        $validators = $validator->errors()->toArray();
        $errorCode = Response::HTTP_UNPROCESSABLE_ENTITY;

        $failed = $validator->failed();

        foreach ($validators as $key => $value) {
            $errors[$key] = $value[0];
        }

        $result['data'] = null;
        $result += $this->responseErrors($errorCode, Response::$statusTexts[$errorCode], !empty($errors) ? reset($errors) : NULL, $errors);
        // $result['errors'] = [
        //     'code' => $errorCode,
        //     'code_msg' => Response::$statusTexts[$errorCode],
        //     'message' => !empty($errors) ? reset($errors) : NULL,
        //     'details' => $errors,
        // ];

        unset($errors);
        unset($this->responseErrors);

        if ($responses) {
            $result['data'] = $responses;
        }

        throw new HttpResponseException(response()->json($result, Response::HTTP_UNPROCESSABLE_ENTITY));
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if (method_exists($this, 'validationFactory')) {
            $this->validationFactory();
        }
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function failedAuthorization()
    {
        $result['message'] = trans('general.unauthorized_user_access');
        $result['errors'] = [
            'code' => '001',
            'message' => $this->exceptionError,
            'exception' => FormRequest::class,
        ];

        throw new HttpResponseException(response()->json($result, $this->unauthorizedStatus));
    }
}

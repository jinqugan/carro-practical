<?php

namespace App\Http\Requests\Register;

use App\Http\Requests\FormRequest;
use Illuminate\Support\Facades\Auth;

class RegisterRequest extends FormRequest
{
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
        return [
            'name' => 'required|string|min:4|max:255|checkspecialcharacter',
            'email' => 'required|string|min:6|max:255|email|unique:users',
            'password' => "required|min:6|max:100|checkspecialcharacter|confirmed",
        ];
    }

    public function messages()
    {
        return [
            'email.required' => trans('login.email_required'),
            'email.email' => trans('login.invalid_email'),
            'email.unique' => trans('login.email_mustbe_unique'),
            'password.required' => trans('login.password_required'),
            'password.regex' => trans('login.password_minumum_required'),
            'password.checkspecialcharacter' => trans('login.password_specialchar', ['character' => config('constant.special_character')]),
        ];
    }

    public function withValidator($validator)
    {
        if ($validator->passes()) {
            $request = $this->all();

            $validator->after(function ($validator) use ($request) {
                if (!preg_match('/[A-Z]/', $request['password'])) {
                    $validator->errors()->add('password', trans('login.at least one uppercase'));
                }

                if (!preg_match('/[a-z]/', $request['password'])) {
                    $validator->errors()->add('password', trans('login.The password must contain at least one lowercase letter.'));
                }

                if (!preg_match('/[0-9]/', $request['password'])) {
                    $validator->errors()->add('password', trans('login.The password must contain at least one number'));
                }
            });
        }
    }
}

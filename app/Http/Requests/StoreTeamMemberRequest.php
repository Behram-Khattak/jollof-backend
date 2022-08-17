<?php

namespace App\Http\Requests;

use App\Rules\PhoneNumber;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreTeamMemberRequest extends FormRequest
{
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
            'team'                  => ['required', 'string'],
            'first_name'            => ['required', 'string', 'max:100'],
            'last_name'             => ['required', 'string', 'max:100'],
            'username'              => ['required', 'string', 'max:255', 'alpha_dash', 'unique:users'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users'],
            'telephone'             => ['required', 'string', 'unique:users', new PhoneNumber()],
            'role'                  => ['required', 'string'],
            'password'              => ['required', 'string', 'min:6'],
            'password_confirmation' => ['required', 'same:password'],
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        session()->flash('message', 'User not added to team. There are errors in the form');

        session()->flash('alert-type', 'error');

        parent::failedValidation($validator);
    }
}

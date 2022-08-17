<?php

namespace App\Http\Requests;

use App\Enums\DefaultRoles;
use App\Enums\TeamRoles;
use App\Rules\PhoneNumber;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
            'role'                  => ['required', Rule::in([DefaultRoles::USER, DefaultRoles::MERCHANT, TeamRoles::MANAGER])],
            'first_name'            => ['required', 'string', 'max:100'],
            'last_name'             => ['required', 'string', 'max:100'],
            'username'              => ['required', 'string', 'max:255', 'alpha_dash', 'unique:users'],
            'email'                 => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'telephone'             => ['required', 'string', new PhoneNumber(), 'unique:users'],
            'password'              => ['required', 'string', 'min:6'],
            'password_confirmation' => ['required', 'same:password'],
            'business_owner'        => ['required_if:role,merchant', Rule::in(['yes', 'no'])],
            'user_role'             => ['required_if:business_owner,no'],
            'business_type'         => ['required_if:role,merchant', 'string'],
            'business_name'         => ['required_if:role,merchant', 'string', 'max:200'],
            'business_description'  => ['required_if:role,merchant', 'string', 'max:200'],
            'business_email'        => ['required_if:role,merchant', 'string', 'email'],
            'business_phone'        => ['required_if:role,merchant', 'string', new PhoneNumber(), 'unique:businesses,telephone'],
            'whatsapp'              => ['required_if:role,merchant', 'string', new PhoneNumber(), 'unique:businesses,whatsapp'],
            'state'                 => ['required_if:role,merchant', 'string'],
            'city'                  => ['required_if:role,merchant', 'string'],
            'area'                  => ['nullable', 'string'],
            'address'               => ['required_if:role,merchant', 'string', 'max:200'],
            'terms'                 => ['accepted'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            '*.required_if' => 'The :attribute field is required.',
            'unique'        => 'The :attribute is already taken.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'telephone' => phone($this->telephone, 'NG')->formatE164(),
        ]);
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
        session()->flash('message', [
            'type'  => 'danger',
            'body'  => 'Registration failed. There are errors in the form.',
        ]);

        parent::failedValidation($validator);
    }
}

<?php

namespace App\Http\Requests;

use App\Rules\PhoneNumber;
use App\Rules\UniqueBusinessField;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'first_name'            => ['required', 'string', 'max:100'],
            'last_name'             => ['required', 'string', 'max:100'],
            'username'              => ['required', 'string', 'max:255', 'alpha_dash', 'unique:users'],
            'email'                 => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role'                  => ['required_without:roles', 'string'],
            'roles'                 => ['required_without:role', 'array', 'min:1'],
            'roles.*'               => ['required_without:role', 'distinct'],
            'telephone'             => ['required_if:role,merchant', 'string', new PhoneNumber(), 'unique:users'],
            'business_type'         => ['required_if:role,merchant', 'string'],
            'business_name'         => ['required_if:role,merchant', 'string', 'max:200'],
            'business_description'  => ['required_if:role,merchant', 'string', 'max:200'],
            'business_email'        => ['required_if:role,merchant', 'string'],
            'business_phone'        => ['required_if:role,merchant', 'string', new PhoneNumber(), new UniqueBusinessField(auth()->user(), 'telephone')],
            'whatsapp'              => ['required_if:role,merchant', 'string', new PhoneNumber(), new UniqueBusinessField(auth()->user(), 'whatsapp')],
            'state'                 => ['required_if:role,merchant', 'string'],
            'city'                  => ['required_if:role,merchant', 'string'],
            'area'                  => ['nullable', 'string'],
            'address'               => ['required_if:role,merchant', 'string', 'max:200'],
        ];
    }

    /** {@inheritdoc} */
    public function messages()
    {
        return [
            '*.required_if'    => 'The :attribute field is required.',
            'required_without' => 'The :attribute field is required.',
            'unique'           => 'The :attribute already belongs to a user.',
        ];
    }
}

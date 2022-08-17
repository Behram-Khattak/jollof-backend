<?php

namespace App\Http\Requests;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTeamMemberRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'username'   => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('users')->ignore($this->user->id)],
            'email'      => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user->id)],
            'telephone'  => ['nullable', 'string', new PhoneNumber(), Rule::unique('users')->ignore($this->user->id)],
        ];
    }
}

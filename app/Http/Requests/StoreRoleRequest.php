<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->isMethod('patch')) {
            return $this->user()->can('update', $this->route('role'));
        }

        return $this->user()->can('create', Role::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'role_name'        => [
                isset($this->role) ? Rule::requiredIf($this->role->is_editable) : 'required',
                'string',
                'max:50',
                'regex:/^[a-zA-Z-]*$/',
                Rule::unique(config('permission.table_names.roles'), 'name')->ignore($this->role),
            ],
            'role_description' => ['nullable', 'string', 'max:200'],
            'permissions'      => ['sometimes', 'array'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function messages()
    {
        return [
            'role_name.regex'  => 'The :attribute can only contain alphabets and dashes.',
            'role_name.unique' => 'A role with the :attribute already exists.',
        ];
    }
}

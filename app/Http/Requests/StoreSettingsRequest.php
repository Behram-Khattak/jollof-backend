<?php

namespace App\Http\Requests;

use App\Models\Settings;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->isMethod('patch')) {
            return $this->user()->can('update', $this->route('settings'));
        }

        return $this->user()->can('create', Settings::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'setting_type_id'  => ['required', 'exists:setting_types,id'],
            'name'             => ['required', 'string', 'unique:settings,name', 'regex:/^[\pL\s]+$/u'],
            'value'            => ['required', 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function messages()
    {
        return [
            'name.regex' => 'The :attribute may only contain letters and spaces.',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param Validator $validator
     *
     * @return Validator
     */
    public function withValidator(Validator $validator)
    {
        if ($validator->fails()) {
            session()->flash('create-setting-modal-open', 'true');
        }

        return $validator;
    }
}

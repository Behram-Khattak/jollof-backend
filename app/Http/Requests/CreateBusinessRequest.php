<?php

namespace App\Http\Requests;

use App\Rules\PhoneNumber;
use App\Rules\UniqueBusinessField;
use Illuminate\Foundation\Http\FormRequest;

class CreateBusinessRequest extends FormRequest
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
            'business_type'         => ['required', 'string'],
            'business_name'         => ['required', 'string', 'max:200'],
            'business_description'  => ['required', 'string', 'max:200'],
            'business_email'        => ['required', 'string'],
            'business_phone'        => ['required', 'string', new PhoneNumber(), new UniqueBusinessField(auth()->user(), 'telephone')],
            'business_whatsapp'     => ['required', 'string', new PhoneNumber(), new UniqueBusinessField(auth()->user(), 'whatsapp')],
            'state'                 => ['required', 'string'],
            'city'                  => ['required', 'string'],
            'area'                  => ['nullable', 'string'],
            'address'               => ['required', 'string', 'max:200'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFashionProductRequest extends FormRequest
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
            // 'featured_image'   => ['required', 'string'],
            'category_id'      => ['required'],
            'color'         => ['required'],
            'material_id'      => ['required'],
            'size_type_id'     => ['nullable'],
            'size_value_id'    => ['required_with:size_type_id'],
            'name'             => ['required', 'min:3', 'max:80'],
            'description'      => ['required', 'min:15', 'max:200'],
            'quantity'         => ['required', 'integer', 'min:0'],
            'price'            => ['required', 'numeric'],
            'sales_price'      => ['nullable', 'numeric', 'lte:price'],
            'weight'           => ['required', 'numeric'],
            'discountSchedule' => [Rule::requiredIf($this->filled('sales_price'))],
            'product_image'   => ['required','array', 'max:4'],
            'is_layaway'       => ['required', 'boolean'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'price'       => (float) $this->input('price'),
            'sales_price' => (float) $this->input('sales_price'),
            'weight'      => (float) $this->input('weight'),
        ]);
    }

    public function messages()
    {
        return [
            'product_image.max' => 'You cannot upload more that 4 images.',
        ];
    }
}

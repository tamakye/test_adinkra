<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product_name' => ['required', 'string', 'max:120'], 
            'product_description' => ['required'], 
            'sku' => ['nullable', 'string'],
            'price' => ['required', 'numeric'], 
            'retail_price' => ['required', 'numeric'], 
            'quantity_in_stock' => ['required', 'numeric', 'min:1'], 
            'product_attributes' => ['nullable', 'array'],
            'product_attributes.*' => ['nullable', 'integer'],
            'attributevalues' => ['nullable', 'array'],
            'attributevalues.*' => ['nullable', 'integer'],
            'attribute_price' => ['nullable', 'array'],
            'attribute_price.*' => ['nullable', 'numeric'],
            'meta_title' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
            'meta_description' => ['nullable', 'string'],
            'poetry_in_jewelry' => ['nullable', 'string'],
            'details' => ['nullable', 'string'],
            'inspiration' => ['required', 'image', 'mimes:jpg,jpeg,png'],
            'status' => ['required', 'string'],
            'product_collection' => ['required', 'integer'],
            'product_conditions' => ['required', 'array'],
            'product_conditions.*' => ['required', 'integer'],
            'product_category' => ['required', 'array'],
            'product_category.*' => ['required', 'integer'],
            'product_material' => ['required', 'integer'],
            'thumbnail' => ['required', 'image', 'mimes:jpg,jpeg,png'],
        ];
    }
}

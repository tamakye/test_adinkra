<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'billing_first_name' => ['required', 'string', 'max:255'],
            'billing_last_name' => ['required', 'string', 'max:255'],
            'billing_address_one' => ['required', 'string', 'max:255'],
            'billing_address_two' => ['required', 'string', 'max:255'],
            'billing_country' => ['required', 'string', 'max:255'],
            'billing_region' => ['required', 'string', 'max:255'],
            'billing_city' => ['required', 'string', 'max:255'],
            'billing_zip_code' => ['required', 'string', 'max:255'],
            'billing_phone' => ['required', 'string', 'max:255'],
            'billing_email' => ['nullable', 'string', 'max:255'],

            'shipping_first_name' => ['required_with:new_address', 'nullable', 'string', 'max:255'],
            'shipping_last_name' => ['required_with:new_address', 'nullable', 'string', 'max:255'],
            'shipping_address_one' => ['required_with:new_address', 'nullable', 'string', 'max:255'],
            'shipping_address_two' => ['required_with:new_address', 'nullable', 'string', 'max:255'],
            'shipping_country' => ['required_with:new_address', 'nullable', 'string', 'max:255'],
            'shipping_region' => ['required_with:new_address', 'nullable', 'string', 'max:255'],
            'shipping_city' => ['required_with:new_address', 'nullable', 'string', 'max:255'],
            'shipping_zip_code' => ['required_with:new_address', 'nullable', 'string', 'max:255'],
            'shipping_phone' => ['required_with:new_address', 'nullable', 'string', 'max:255'],
            'shipping_email' => ['nullable', 'string', 'max:255'],

            'order_notes' => ['nullable', 'string', 'max:500'],

        ];
    }
}

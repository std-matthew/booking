<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceStoreRequest extends FormRequest
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
            'billing_firstname' => 'required|string',
            'billing_lastname' => 'required|string',
            'billing_email' => 'required|email',
            'remarks' => 'nullable|string',
            'terms' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'billing_firstname.required' => 'Please enter your first name',
            'billing_lastname.required' => 'Please enter your last name',
            'billing_email.required' => 'Please enter your email address',
            'terms.required' => 'You have to agree with the terms and conditions',
        ];
    }
}

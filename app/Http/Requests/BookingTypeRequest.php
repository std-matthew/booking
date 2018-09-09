<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BookingDateRequest;

class BookingTypeRequest extends BookingDateRequest
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
        return array_merge(parent::rules(), [
            'booking_type_id' => 'required|exists:booking_types,id',
        ]);
    }

    public function messages()
    {
        return array_merge(parent::messages(), [
            'booking_type_id.required' => 'Please select a type',
            'booking_type_id.exists' => 'Type not found',
        ]);
    }
}

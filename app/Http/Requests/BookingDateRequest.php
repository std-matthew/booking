<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingDateRequest extends FormRequest
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
            'booking_location_id' => 'required|exists:booking_locations,id',
            'booking_date' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'booking_location_id.required' => 'Please select a location',
            'booking_location_id.exists' => 'Location not found',
            'booking_date.required' => 'Please select a date',
        ];
    }
}

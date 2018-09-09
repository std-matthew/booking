<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BookingTypeRequest;

use App\BookingTime;
use App\BookingLocation;
use App\BookingType;

class BookingTimeRequest extends BookingTypeRequest
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
        $maxQuantity = 0;

        $date = $this->input('booking_date');
        $time = BookingTime::find($this->input('booking_time_id'));
        $location = BookingLocation::find($this->input('booking_location_id'));
        $type = BookingType::find($this->input('booking_type_id'));

        if ($time) {
            $maxQuantity = $time->renderAvailableSlots($date, $location, $type);
        }

        return array_merge(parent::rules(), [
            'booking_time_id' => 'required|exists:booking_times,id',
            'quantity' => 'required|numeric|min:1|max:' . $maxQuantity,
        ]);
    }

    public function messages()
    {
        return array_merge(parent::messages(), [
            'booking_time_id.required' => 'Please select a time',
            'booking_time_id.exists' => 'Time not found',
            'quantity.required' => 'Please enter quantity',
        ]);
    }
}

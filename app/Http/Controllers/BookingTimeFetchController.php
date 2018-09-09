<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\BookingLocation;
use App\BookingType;
use App\BookingTime;

class BookingTimeFetchController extends Controller
{
    public function fetch(Request $request)
    {
        $lists = [];
        $type = BookingType::find($request->input('booking_type_id'));
        $location = BookingLocation::find($request->input('booking_location_id'));
        $ids = $type->times()->pluck('id');
        $times = BookingTime::whereIn('id', $ids)->orderBy('start_time', 'asc')->get();


        foreach ($times as $key => $time) {
        	$time->available_slots = $time->renderAvailableSlots($request->input('booking_date'), $location, $type);
            array_push($lists, $time);
        }

        return response()->json([
            'lists' => $lists,
        ]);
    }
}

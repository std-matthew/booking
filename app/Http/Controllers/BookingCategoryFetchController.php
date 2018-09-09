<?php

namespace App\Http\Controllers;

use App\BookingLocation;
use App\BookingCategory;
use Illuminate\Http\Request;

class BookingCategoryFetchController extends Controller
{
    public function fetch(Request $request)
    {
        $lists = BookingLocation::find($request->input('booking_location_id'))->categories()->with('types')->get();

        return response()->json([
            'lists' => $lists,
        ]);
    }
}

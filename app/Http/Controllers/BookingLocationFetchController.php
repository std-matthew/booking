<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\BookingLocation;

class BookingLocationFetchController extends Controller
{
    public function fetch() {

    	$lists = BookingLocation::all();

    	return response()->json([
    		'lists' => $lists,
    	]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BookingTimeRequest;

use App\BookingTime;

class BookingTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookingTimeRequest $request)
    {
        return response()->json(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BookingTime  $bookingTime
     * @return \Illuminate\Http\Response
     */
    public function show(BookingTime $bookingTime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BookingTime  $bookingTime
     * @return \Illuminate\Http\Response
     */
    public function edit(BookingTime $bookingTime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BookingTime  $bookingTime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BookingTime $bookingTime)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BookingTime  $bookingTime
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookingTime $bookingTime)
    {
        //
    }
}

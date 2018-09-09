<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BookingDateRequest;

use App\BookingLocation;

class BookingLocationController extends Controller
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
    public function store(BookingDateRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BookingLocation  $bookingLocation
     * @return \Illuminate\Http\Response
     */
    public function show(BookingLocation $bookingLocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BookingLocation  $bookingLocation
     * @return \Illuminate\Http\Response
     */
    public function edit(BookingLocation $bookingLocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BookingLocation  $bookingLocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BookingLocation $bookingLocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BookingLocation  $bookingLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookingLocation $bookingLocation)
    {
        //
    }
}

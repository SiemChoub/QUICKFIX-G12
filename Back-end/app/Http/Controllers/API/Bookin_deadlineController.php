<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bookin_deadline;
use App\Models\Booking;


class Bookin_deadlineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $bookin_deadline = Bookin_deadline::all();
        return response()->json($bookin_deadline);
    }
    public function store(Request $request)
    {
    /**
     * Store a newly created resource in storage.
     */
    // $validatedData = $request->validate([
    //     'service_id' => 'required|integer',
    //     'date' => 'required|string',
    //     'user_id' => 'required|integer',
    //     'promotion_id' => 'nullable|integer',
    //     'fixer_id' => 'nullable|integer',
    //     'latitude' => 'required|string', 
    //     'longitude' => 'required|string', 
    // ]);

    // Parse the location input
    // $location = explode(',', $validatedData['location']);
    // $latitude = $location[0];
    // $longitude = $location[1];

    // Create a new Bookin_immediately record
    $booking_deadline = new Bookin_deadline();
    $booking_deadline->service_id = $request->service_id;
    $booking_deadline->user_id = $request->user_id;
    $booking_deadline->latitude = $request->latitude;
    $booking_deadline->longitude = $request->longitude;
    $booking_deadline->date = $request->date;
    $booking_deadline->message = $request->message;
    if(isset($request->promotion_id)) {
        $booking_deadline->promotion_id = $request->promotion_id;
    }
    $booking_deadline->save();

    // Create a new Booking record
    $booking = new Booking();
    $booking->booking_type_id = $booking_deadline->id;
    $booking->user_id = $request->user_id;
    $booking->type = 'deadline';
    if (isset($request->fixer_id)) {
        $booking->fixer_id = $request->fixer_id;
    }
    $booking->save();

    return response()->json($booking_deadline);
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

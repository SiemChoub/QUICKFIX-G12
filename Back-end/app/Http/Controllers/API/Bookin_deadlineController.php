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
    $validatedData = $request->validate([
        'service_id' => 'required|integer',
        'date' => 'required|string',
        'user_id' => 'required|integer',
        'promotion_id' => 'nullable|integer',
        'fixer_id' => 'nullable|integer',
        'latitude' => 'required|string', 
        'longitude' => 'required|string', 
    ]);

    // Parse the location input
    // $location = explode(',', $validatedData['location']);
    // $latitude = $location[0];
    // $longitude = $location[1];

    // Create a new Bookin_immediately record
    $bookin_immediately = new Bookin_deadline();
    $bookin_immediately->service_id = $validatedData['service_id'];
    $bookin_immediately->user_id = $validatedData['user_id'];
    $bookin_immediately->latitude = $validatedData['latitude'];
    $bookin_immediately->longitude = $validatedData['longitude'];
    $bookin_immediately->date = $validatedData['date'];
    $bookin_immediately->message = $validatedData['message'];
    if(isset($validatedData['promotion_id'])) {
        $bookin_immediately->promotion_id = $validatedData['promotion_id'];
    }
    $bookin_immediately->save();

    // Create a new Booking record
    $booking = new Booking();
    $booking->booking_type_id = $bookin_immediately->id;
    $booking->user_id = $validatedData['user_id'];
    $booking->type = 'deadline';
    if (isset($validatedData['fixer_id'])) {
        $booking->fixer_id = $validatedData['fixer_id'];
    }
    $booking->save();

    return response()->json($bookin_immediately);
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

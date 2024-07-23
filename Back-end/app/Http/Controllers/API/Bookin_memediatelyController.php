<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingDeadlineResource;
use Illuminate\Http\Request;
use App\Models\Bookin_immediately;
use App\Models\User;
use App\Models\Booking;
use App\Models\FixingProgress;

class Bookin_memediatelyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $bookin_memediately = Bookin_immediately::all();
        $bookin_memediately = BookingDeadlineResource::collection($bookin_memediately);

        return response()->json($bookin_memediately);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
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
        $bookin_immediately = new Bookin_immediately();
        if(isset($request->service_id)) {
            $bookin_immediately->service_id = $request->service_id;
        }
        $bookin_immediately->user_id = $request->user_id;
        $bookin_immediately->latitude = $request->latitude;
        $bookin_immediately->longitude = $request->longitude;
        $bookin_immediately->date = $request->date;
        $bookin_immediately->message = $request->message;
        if(isset($requestpromotion_id)) {
            $bookin_immediately->promotion_id = $requestpromotion_id;
        }
        $bookin_immediately->save();
    
        // Create a new Booking record
        $booking = new Booking();
        $booking->booking_type_id = $bookin_immediately->id;
        $booking->user_id = $request->user_id;
        $booking->type = 'immediately';
        if (isset($request->fixer_id)) {
            $booking->fixer_id = $request->fixer_id;
        }
        $booking->save();
        if (isset($request->fixer_id)) {
            FixingProgress::create([
               'fixer_id' => $request->fixer_id,
               'booking_id' => $booking->id,
               'action' => 'progress',
           ]);
           $booking = Booking::findOrFail($request->booking_id);
           $booking->action = 'progress';
           $booking->fixer_id = $request->fixer_id;
           $booking->save();

        }
    
    
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

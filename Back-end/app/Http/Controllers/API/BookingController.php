<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use App\Models\Bookin_immediately;
use App\Models\Bookin_deadline;
use App\Models\FixingProgress;


class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    try {
        $action = 'request'; 
        $bookings = Booking::where('action', $action)
                    ->whereNull('fixer_id')
                    ->get();
        $count = $bookings->count(); 
        
        $bookingsData = BookingResource::collection($bookings);
        
        return response()->json([
            'bookings' => $bookingsData,
            'count' => $count
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to fetch bookings.',
            'error' => $e->getMessage()
        ], 500);
    }
}



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        
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
    public function update(Request $request, int $id)
    {
        //
        $booking = Booking::find($id);
        $booking->action = 'accepted';
        $booking->save();

        $fixingProgress = new FixingProgress();
        $fixingProgress->booking_type_id = $booking['booking_type_id'];
        $fixingProgress->type = $booking['type'];
        $fixingProgress->user_id = $booking['user_id'];
        $fixingProgress->booking_id = $id;
        if ($booking->fixer_id != null) {
            $fixingProgress->fixer_id = $booking->fixer_id;  
        }else{
            $fixingProgress->fixer_id = $request->fixer_id;  
        }
        $fixingProgress->type = $booking->type;
        $fixingProgress->save();
        
        return response()->json(['booking'=>$booking,'fixingProgress'=>$fixingProgress]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,string $id)
    {
        $booking = Booking::find($id);
        if($booking['type'] == 'immediately'){
            $bookin_immediately = Bookin_immediately::find($booking->booking_type_id);
            if($request->user == 'user'){
                $bookin_immediately->action='cancel';
            }else{
                $bookin_immediately->action='unaccept';
            }
            $bookin_immediately->save();
        }else{
            $bookin_deadline = Bookin_deadline::find($booking->booking_type_id);
            if($request->user == 'user'){
                $bookin_deadline->action='cancel';
            }else{
                $bookin_deadline->action='unaccept';
            }
            $bookin_deadline->save();
        }
        $booking->delete();
        return response()->json(['message' => 'Booking cenceled successfully']);
    }
}

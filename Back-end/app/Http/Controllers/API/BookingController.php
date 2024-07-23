<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Http\Resources\BookingShow;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use App\Models\Bookin_immediately;
use App\Models\Bookin_deadline;
use App\Models\FixingProgress;
use App\Models\Service;

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
    public function show(int $id)
    {
        try {
            $action = 'request';
    
            $bookings = Booking::where('user_id', $id)
                             ->where('action', $action)
                             ->with('user') 
                             ->get();
    
            $bookingsData = BookingShow::collection($bookings);
    
            return response()->json([
                'bookings' => $bookingsData,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch bookings.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

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
            if($request->user == $bookin_immediately->user_id){
                $bookin_immediately->delete();
            }
            $bookin_immediately->save();
        }else{
            $bookin_deadline = Bookin_deadline::find($booking->booking_type_id);
            if($request->user == $bookin_deadline->user_id){
                $bookin_deadline->delete();
            }
            $bookin_deadline->save();
        }
        $booking->delete();
        return response()->json(['message' => 'Booking cenceled successfully']);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Bookin_immediately;
use App\Models\Booking;
use App\Models\FixingProgress;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FixingProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $fixingProgress = FixingProgress::all();
        return response()->json([
            'fixingProgress' => $fixingProgress
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'fixer_id' => 'required|exists:users,id',
            'booking_id' => 'required|exists:bookings,id',
        ]);

        try {
            $fixingProgress = FixingProgress::create([
                'fixer_id' => $request->fixer_id,
                'booking_id' => $request->booking_id,
                'action' => 'progress',
            ]);

            $booking = Booking::findOrFail($request->booking_id);
            $booking->action = 'progress';
            $booking->fixer_id = $request->fixer_id;
            $booking->save();

            return response()->json([
                'message' => 'FixingProgress created and booking updated successfully!',
                'data' => $fixingProgress
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create FixingProgress or update booking!',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function update(Request $request, string $id)
    {

        $fixingProgress = FixingProgress::find($id)->where;
        $fixingProgress->action = $request->action;

        $fixingProgress->save();

        return response()->json($fixingProgress);
    }
    public function cancelAccept(Request $request, string $id)
    {
        $fixingProgress = FixingProgress::find($id);
        $booking = Booking::findOrFail($request->booking_id);
        $booking->action = 'request';
        $booking->fixer_id = null;
        $booking->save();
        $fixingProgress->delete();

        return response()->json($fixingProgress);
    }
    public function show($id)
    {
        try {
            $acceptedBookings = FixingProgress::where('fixer_id', $id)
                ->get();

            return response()->json([
                'success' => true,
                'accepted_bookings' => $acceptedBookings
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Fixer not found.'
            ], 404);
        }
    }
    public function startFixer(string $id)
    {
        $fixingProgress = FixingProgress::find($id);
        
        if (!$fixingProgress) {
            return response()->json(['error' => 'Fixing progress not found'], 404);
        }

        $booking = Booking::findOrFail($fixingProgress->booking_id);

        $bookImmediately = Bookin_immediately::where('booking_id', $booking->id)->first();
        if (!$bookImmediately) {
            return response()->json(['error' => 'BookImmediately record not found'], 404);
        }

        $latitude = $bookImmediately->latitude;
        $longitude = $bookImmediately->longitude;

        $fixingProgress->action = 'started';
        $fixingProgress->save();

        $booking->status = 'in_progress';
        $booking->save();

        return response()->json([
            'message' => 'Fixing process started successfully',
            'fixingProgress' => $fixingProgress,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);
    }

}
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $bookin_deadline = new Bookin_deadline();
        $bookin_deadline->service_id = $request->service_id;
        $bookin_deadline->date_todo = $request->date_todo;
        $bookin_deadline->image = $request->image;
        $bookin_deadline->message = $request->message;
        $bookin_deadline->save();

        $bookig = new Booking();
        $bookig->booking_type_id = $bookin_deadline->id;
        $bookig->user_id = $request->user_id;
        $bookig->type='deadline';
        $bookig->fixer_id = $request->fixer_id;
        $bookig->save();

        return response()->json($bookin_deadline);
        
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

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bookin_immediately;
use App\Models\User;
use App\Models\Booking;

class Bookin_memediatelyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $bookin_memediately = Bookin_immediately::all();
        return response()->json($bookin_memediately);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $bookin_memediately = new Bookin_immediately();
        $bookin_memediately->service_id = $request->service_id;
        $bookin_memediately->image = $request->image;
        $bookin_memediately->message = $request->message;
        $bookin_memediately->save();

        $bookig = new Booking();
        $bookig->booking_type_id = $bookin_memediately->id;
        $bookig->user_id = $request->user_id;
        $bookig->type='immediately';
        $bookig->save();

        return response()->json($bookig); 
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

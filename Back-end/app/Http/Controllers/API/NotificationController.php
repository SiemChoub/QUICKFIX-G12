<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // dd(1);
        $notification = Notification::all();
        $notification= NotificationResource::collection($notification);
        return response()->json($notification);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $notification = new Notification();
        $notification->text = $request->text;
        $notification->booking_id = $request->booking_id;
        $notification->role_id = $request->role_id;
        $notification->save();

        return response()->json($notification, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $notification = Notification::find($id);
        return new NotificationResource($notification);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $notification = Notification::find($id);
        $notification->booking_id = $request->booking_id;
        $notification->role_id = $request->role_id;
        $notification->save();

        return response()->json($notification);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $notification = Notification::find($id);
        $notification->delete();

        return response()->json(['Deleted successfuly', 204]);
    }
}

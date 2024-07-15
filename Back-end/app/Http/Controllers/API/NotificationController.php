<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        $notifications = Notification::all();
        return response()->json($notifications);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Notification::create([
            'user_id' => $request->user_id,
            'content' => $request->content
        ]);

        return "Notification created successfully";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $notification = Notification::findOrFail($id);

        return response()->json([
            'notification' => $notification
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        Notification::find($id)->update(
            [
                'user_id' => $request->user_id,
                'content' => $request->content
            ]
        );
        return "Notification updated successfully";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Notification::find($id)->delete();
        return "Notification deleted successfully";
    }
}

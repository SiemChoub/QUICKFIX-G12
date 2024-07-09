<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $chats = Chat::all();
        return response()->json($chats);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Chat::create(
            [
                'sender_id' => $request->sender_id,
                'receiver_id' => $request->receiver_id,
                'message' => $request->message,
                'is_read' => $request->is_read,
            ]
        );
        return "Chat created successfully";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $chat = Chat::find($id);
        return $chat;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        Chat::find($id)->update(
            [
                'sender_id' => $request->sender_id,
                'receiver_id' => $request->receiver_id,
                'message' => $request->message,
                'is_read' => $request->is_read,
            ]
        );
        return "Chat updated successfully";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Chat::find($id)->delete();
        return "Chat deleted successfully";
    }
}

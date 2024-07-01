<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:User access|User create|User edit|User delete', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:User create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:User edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:User delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $users = User::latest()->get();

        return view('setting.user.index', ['users' => $users]);
    }

    public function create()
    {
        return view('setting.user.new');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->role = $request->role;
        $user->save();

        return redirect()->back()->withSuccess('User created!');
    }

    public function edit(User $user)
    {
        return view('setting.user.edit', ['user' => $user]);
    }

    // app/Http/Controllers/UserController.php
    public function update(Request $request)
    {
        // Validate the request data
        $request->validate([
            'role' => 'required',
            'name' => 'required',
            'phone' => 'required',
        ]);

        // Update the user data
        $user = auth()->user();
        $user->role = $request->input('role');
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->save();

        return response()->json(['message' => 'User updated successfully']);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back()->withSuccess('User deleted!');
    }
}

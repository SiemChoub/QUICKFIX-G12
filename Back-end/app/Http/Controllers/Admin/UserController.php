<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $users = User::paginate(5);

        return view('setting.user.index', ['users' => $users]);
    }

    public function create()
    {
        $roles = Role::all();
        return view('setting.user.new',compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'address' => 'required',
            'password' => 'required|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => bcrypt($request->password),
        ]);
        $user->save();

        return redirect()->back()->withSuccess('User created!');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('setting.user.edit', ['user' => $user],compact('roles'));
    }


    $user_id = Auth::id();
    $user = User::find($user_id);

    if ($request->hasFile('profile')) {
        $image = $request->file('profile');
        $imageBase64 = base64_encode(file_get_contents($image->getRealPath()));

        $base64String = 'data:image/' . $image->getClientOriginalExtension() . ';base64,' . $imageBase64;
        $user->profile = $base64String;
    }

    $user->save();

    return response()->json([
        'message' => 'User profile image updated successfully',
        'user' => $user,
    ], 200);
}

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back()->withSuccess('User deleted!');
    }

    public function updateInformation(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
        ]);

        // Update the user data
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->save();

        return response()->json(['message' => 'User updated successfully']);
    }
}

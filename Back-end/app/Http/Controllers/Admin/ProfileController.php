<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Traits\UploadImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    use UploadImage;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        return view('setting.profile',['user'=>$user]);
    }


    /**
     * Update the authenticated user's profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::id());

        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,' . $user->id,
            'profile' => 'nullable|image|max:2048', // optional image upload validation
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Update user attributes
        $user->email = $request->email;

        // Handle profile image upload if provided
        if ($request->hasFile('profile')) {
            $image = $request->file('profile');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Convert image to base64
            $imageBase64 = base64_encode(file_get_contents($image->getRealPath()));

            // Create the base64 string in the format: data:image/{mime};base64,{base64data}
            $base64String = 'data:image/' . $image->getClientOriginalExtension() . ';base64,' . $imageBase64;

            $user->profile = $base64String;
        }

        // Save the updated user
        $user->save();

        return response()->json([
            'message' => 'User profile updated successfully',
            'user' => $user,
        ], 200);
    }
}

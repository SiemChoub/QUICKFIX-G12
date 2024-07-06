<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'User not found'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login success',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        // $permissions = $user->getAllPermissions();
        // $roles = $user->getRoleNames();
        return response()->json([
            'message' => 'Login success',
            'data' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout successful'
        ]);
    }
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
            'remember_token' => Str::random(20),
        ]);

        $user->assignRole('user');
        $user->givePermissionTo(['Mail access']); // Adjust as per your application's needs

        $tokenResult = $user->createToken('auth_token');

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'access_token' => $tokenResult->plainTextToken,
            'token_type' => 'Bearer',
        ], 201);
    }

    public function update(Request $request)
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

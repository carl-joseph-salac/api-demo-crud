<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'require|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json(['user' => $user], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required'
        ]);

        // Attempt to authenticate the user using the provided email and password
        if (!Auth::attempt($request->only('email', 'password'))) {
            // If authentication fails, return a JSON response with a 401 (Unauthorized) status code
            return response()->json(['message' => 'Invalid Credentials'], 401);
        }

        $user = $request->user(); // Retrieve the authenticated user

        // Create a new personal access token for the user with the name 'authToken'
        $token = $user->createToken('authToken')->plainTextToken;

        // Return a JSON response with the user information and the generated token
        return response()->json(['user' => $user, 'token' => $token]);
    }

    public function logout(Request $request)
    {
        // Retrieve the authenticated user's current access token and delete it
        $request->user()->token()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
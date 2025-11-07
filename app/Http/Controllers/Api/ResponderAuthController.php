<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Responder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ResponderAuthController extends Controller
{
   public function login(Request $request){
        $request->validate([
            'identifier' => 'required|string',  // Email or username
            'password' => 'required|string',
        ]);

        $identifier = $request->identifier;
        $password = $request->password;

        // Manually retrieve user by email or username
        $user = Responder::where('res_email', $identifier)
            ->orWhere('res_username', $identifier)
            ->first();

        // Validate user exists and password matches
        if (!$user || !Hash::check($password, $user->res_password)) {
            throw ValidationException::withMessages([
                'identifier' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Create Sanctum token (this is all that's needed for API auth)
        $token = $user->createToken('responder-token')->plainTextToken;

        // No need for setUser() in API context—token handles user resolution

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ]);
    }


    public function logout(Request $request){
        $request->user('responder')->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
    

    public function me(Request $request){
        return response()->json($request->user('responder'));  // Or auth('responder')->user()
    }
    
}

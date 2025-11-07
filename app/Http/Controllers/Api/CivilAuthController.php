<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\OtpMail;

class CivilAuthController extends Controller // Updated class name
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:civil', // Note: Table name in unique rule
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional image upload
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:255',
            'birthday' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',
            'street_purok' => 'required|string|max:255',
            'baranggay' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:civil',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public'); // Store in storage/app/public/images
        }

        $user = User::create([
            'username' => $request->username,
            'image' => $imagePath,
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'suffix' => $request->suffix,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'street_purok' => $request->street_purok,
            'baranggay' => $request->baranggay,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('CivilApp')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('CivilApp')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|exists:civil,email', // Note: Table name in exists rule
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $otp = rand(100000, 999999); // Generate 6-digit OTP
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['otp' => $otp, 'created_at' => now()]
        );

        Mail::to($request->email)->send(new OtpMail($otp));

        return response()->json(['message' => 'OTP sent to your email']);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'otp' => 'required|string|size:6',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $reset = DB::table('password_resets')->where('email', $request->email)->first();

        if (!$reset || $reset->otp !== $request->otp || now()->diffInMinutes($reset->created_at) > 10) {
            return response()->json(['message' => 'Invalid or expired OTP'], 422);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        return response()->json(['message' => 'Password reset successfully']);
    }
}
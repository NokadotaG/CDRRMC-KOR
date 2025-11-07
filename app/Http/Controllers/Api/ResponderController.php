<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ResponderController extends Controller
{
    public function dashboard(Request $request){
        return response()->json([
            'message'=> 'Responder Dashboard',
            'user'=> $request->user('responder'),
        ]);
    }
    public function updateProfile(Request $request){
        $user = $request->user('responder');  // Get authenticated responder (Sanctum token)
        $validationRules = [
            'res_fname' => 'sometimes|required|string|max:255',
            'res_mname' => 'sometimes|string|max:255',
            'res_lname' => 'sometimes|required|string|max:255',
            'res_suffix' => 'sometimes|string|max:10',
            'res_contact' => [
                'sometimes',
                'required',
                'string',
                'max:20',
                Rule::unique('responders', 'res_contact')->ignore($user->id),  // Ignore current user ID
            ],
            'res_position' => 'sometimes|required|string|max:255',
            'res_company' => 'sometimes|required|string|max:255',
            'res_workadd' => 'sometimes|required|string|max:500',
            'res_image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Optional image upload (2MB)
        ];
        // Password is optional (only validate if provided)
        if ($request->filled('res_password')) {
            $validationRules['res_password'] = 'sometimes|required|min:8|confirmed';
        }
        $request->validate($validationRules);
        $updateData = $request->only([
            'res_fname', 'res_mname', 'res_lname', 'res_suffix', 'res_contact',
            'res_position', 'res_company', 'res_workadd'
        ]);
        // Hash password if provided
        if ($request->filled('res_password')) {
            $updateData['res_password'] = Hash::make($request->res_password);
        }
        // Handle image upload (optional)
        if ($request->hasFile('res_image')) {
            // Delete old image if exists
            if ($user->res_image) {
                Storage::disk('public')->delete($user->res_image);
            }
            // Store new image
            $updateData['res_image'] = $request->file('res_image')->store('images/responders', 'public');
        }
        // Update the user
        $user->update($updateData);
        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user->fresh(),  // Reload from DB for latest data
        ], 200);
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);
        $responder = $request->user('responder');
        if (!Hash::check($request->current_password, $responder->res_password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Current password is incorrect.'],
            ]);
        }
        $responder->update(['res_password' => Hash::make($request->password)]);
        return response()->json(['message' => 'Password updated successfully']);
    }

    public function uploadProfileImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',  // Validate image (max 2MB, common formats)
        ]);
        $user = Auth::user();  // Assuming Sanctum auth; adjust if using JWT or session
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($user->res_image && Storage::disk('public')->exists($user->res_image)) {
                Storage::disk('public')->delete($user->res_image);
            }
            // Store new image
            $path = $request->file('image')->store('profile_images', 'public');  // Saves to storage/app/public/profile_images/
            $user->res_image = $path;  // Update the user's res_image field
            $user->save();
            return response()->json([
                'message' => 'Profile image updated successfully.',
                'user' => $user,  // Return updated user data
            ]);
        }
        return response()->json(['message' => 'No image provided.'], 400);
    }
}

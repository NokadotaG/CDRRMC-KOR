<?php

namespace App\Http\Controllers;

use App\Models\Responder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
        return view('auth.login');
    }
    function loginPost(Request $request){
        $request->validate([
            "email"=> "required",
            "password" => "required",
        ]);

        $credentials = $request->only("email","password");
        if(Auth::attempt($credentials)){
            return redirect()->intended(route("dashboard"));
        }
         return redirect(route("login"))->with("error","Failed to login");
    }
    public function register(Request $request){
        return view('auth.register');
    }
    function registerPost(Request $request){
        $request->validate([
            "name"=>"required",
            "email"=>"required",
            "password"=>"required|confirmed|min:6",
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        if($user -> save()){
         return redirect(route("login"))->with("success","User created Successfully!");
      }
      return redirect(route("register"))->with("error","Failed to create");
    }

    public function logout(Request $request){
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
    return redirect()->route('login')->with('success', 'You have been logged out successfully.');

        // if($request->wantsJson()){
        //     $request->user()->currentAccessToken()->delete();
        //     return response()->json(['message' => 'Logged out Successfully']);
        // }

        // auth()->guard('admin')->logout();
        // return redirect()->route('login');
    }

    public function dashboard(){
        $user = auth()->user();
        $responder = Responder::count();
        return view("dashboard",compact("user", "responder"));
    }
    
}

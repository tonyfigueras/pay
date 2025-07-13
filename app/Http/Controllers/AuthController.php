<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function getRole(){
        $roles = auth()->user()->getRoleNames();
        return response()->json([
            'roles' => $roles,
        ]);
    }

    public function userInfo(){
        $user = auth('api')->user();
        return response()->json([
            'user' => $user,
        ]);
    }

    public function checkAuth(){
        if(Auth::guard('api')->check()){
            return response()->json([
                "LoggedIn" => true,
                "message" => "Logged in",
            ]);
        }
        return response()->json([
            "LoggedIn" => false,
            "message" => "Not Logged in",
        ]);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if(!auth()->attempt($loginData)) {
            return response()->json([
                "code" => 401,
                "message" => "Password is incorrect or account does not exist.",
            ], 401);
        }

        $accessToken = auth()->user()->createToken('authToken')->plainTextToken;

        $roles = auth()->user()->getRoleNames();

        $user = auth()->user();

        if(auth()->user()->active == 0){
            return response()->json([
                "code" => 401,
                "message" => "Account deactivated.",
            ], 401);
        }

        return response()->json([
            "code" => 200,
            "message" => "Authentication successful",
            "access_token" => $accessToken,
            "role" => $roles,
            "user" => $user,
        ]);
    }

    public function loginAdmin(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if(!auth()->attempt($loginData)) {
            return response()->json([
                "code" => 401,
                "message" => "Password is incorrect or account does not exist.",
            ], 401);
        }

        $accessToken = auth()->user()->createToken('authToken')->plainTextToken;

        $roles = auth()->user()->getRoleNames();

        $user = auth()->user();

        if(auth()->user()->active == 0){
            return response()->json([
                "code" => 401,
                "message" => "Account deactivated.",
            ], 401);
        }

        return response()->json([
            "code" => 200,
            "message" => "Authentication successful",
            "access_token" => $accessToken,
            "role" => $roles,
            "user" => $user,
        ]);
    }

    public function logout(){
        $user = auth('api')->user()->token();
        $user->revoke();
        return response()->json([
            "message" => "Logged out",
        ], 200);
    }

    public function updateEmail(Request $request){
        $user = auth()->user();
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $userExists = User::where('email', $validated['email'])->first();

        if ($userExists) {
            return response()->json([
                'message' => 'User with this email already exists',
            ], 409);
        }

        $user->email = $validated['email'];
        $user->save();
        return response()->json([
            'message' => 'email updated successfully',
        ], 200);
    }

    public function updatePassword(Request $request)
    {
        // Validate the request data
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Get the authenticated user
        $user = $request->user();

        // Check if the current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'The current password is incorrect.'], 401);
        }

        // Update the user's password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Return a success response
        return response()->json(['message' => 'Password updated successfully.'], 200);
    }
}

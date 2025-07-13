<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUserInfo(){
        $user = User::with('products')->find(auth('sanctum')->user()->id); // Multiple relationships
        return response()->json(['user' => $user]);
    }

    public function setUserName(Request $request){
        $user = auth('sanctum')->user();
        $validation = $request->validate([
            'name' => 'required',
        ]);
        $user->update(['name' => $validation['name']]);
        return response()->json([
            'message' => 'Username updated successfully',
        ]);
    }

    public function createUser(Request $request){
        $validation = $request->validate([
            'username' => 'required',
            'email' => 'required'
        ]);
    }

    public function getRole(){
        $roles = auth()->user()->getRoleNames();
        return response()->json([
            'roles' => $roles,
        ]);
    }
}

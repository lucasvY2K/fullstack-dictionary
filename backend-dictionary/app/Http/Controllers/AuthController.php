<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function signUp(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string'
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => 'Error message'
            ], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'token' => $token,
        ], 200);
    }

    public function signin(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string'
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => 'Error message'
            ], 400);
        }

        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['message' => 'Error message'], 400);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'token' => $token,
        ], 200);
    }

    public function show(Request $request) {
        $user_id = Auth::user()->id;

        $user = User::where('id', $user_id)->first();

        return response()->json($user, 200);
    }
}

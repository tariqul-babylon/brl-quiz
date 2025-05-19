<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'contact' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'contact' => $request->contact,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function getToken(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'contact' => 'required|string',
            'email' => 'required|email',
            'password' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'code' => 401,
                    'message' => 'Invalid credentials'
                ], 401);
            }
        } else {
           $user = User::create([
                'name' => $request->name,
                'contact' => $request->contact,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
        }

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'code' => 200,
            'message' => 'Login successful',
            'data' => [
                'user' => new UserResource($user),
                'token' => $token
            ]
        ]);
    }

    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}

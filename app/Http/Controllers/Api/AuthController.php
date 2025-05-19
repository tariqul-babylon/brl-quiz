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
                    'message' => 'Invalid credentials. You can reset your password by forget password link.'
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
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class VerifySanctumToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$abilities): Response
    {
        // Get the token from the Authorization header
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'code' => 401,
                'message' => 'Unauthorized - Token not provided'
            ], 401);
        }

        // Find the token in the database
        $accessToken = PersonalAccessToken::findToken($token);
        
        if (!$accessToken) {
            return response()->json([
                'code' => 401,
                'message' => 'Unauthorized - Invalid token'
            ], 401);
        }

        // Check token abilities if any are specified
        if (!empty($abilities)) {
            foreach ($abilities as $ability) {
                if (!$accessToken->can($ability)) {
                    return response()->json([
                        'code' => 403,
                        'message' => 'Unauthorized - Insufficient permissions'
                    ], 403);
                }
            }
        }

        // Authenticate the user
        auth()->login($accessToken->tokenable);

        return $next($request);
    }
}
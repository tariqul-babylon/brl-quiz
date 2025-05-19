<?php 
namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;

class EnsureJsonResponse
{
    public function handle($request, Closure $next, ...$guards)
    {
        try {
            return $next($request);
        } catch (AuthenticationException $e) {
            return response()->json([
                'message' => 'Unauthenticated.',
                'success' => false
            ], 401);
        }
    }
}
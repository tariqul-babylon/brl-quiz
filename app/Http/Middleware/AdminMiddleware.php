<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $admin_emails = config('services.admin.emails');
        if (in_array(auth()->user()->email, explode(',', $admin_emails)) === false) {
            return abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}

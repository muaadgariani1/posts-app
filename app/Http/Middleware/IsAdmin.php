<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if a user is logged in AND if the user's is_admin column is true (1)
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // If not an admin, deny access with a 403 Forbidden response.
        abort(403, 'Unauthorized. Only Admins can access this area.');
    }
}

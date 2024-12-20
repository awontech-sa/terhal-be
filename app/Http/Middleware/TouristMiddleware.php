<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TouristMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::guard('sanctum')->check()) {
            $user = Auth::user();

            // Assuming the 'user_types' table has a 'name' column for roles (like 'سائح')
            if ($user->userType && $user->userType->user_type === 'tourist') {
                return $next($request);
            }
        }


        // Redirect or abort if the user is not an tourist
        return redirect('/')->with('error', 'Unauthorized access.');
    }
}

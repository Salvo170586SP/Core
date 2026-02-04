<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if redirect_to is set in session (set after login)
        if (session()->has('redirect_to')) {
            $redirectTo = session()->pull('redirect_to');
            return redirect($redirectTo);
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // If the user is not authenticated or not an admin, redirect to login
        if (! $user || ($user->role ?? null) !== 'admin') {
            return redirect()->route('login');
        }

        return $next($request);
    }
}

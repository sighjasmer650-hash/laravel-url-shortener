<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(
        Request $request,
        Closure $next,
        ...$roles
    ): Response {

        // User login nahi hai
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Logged-in user
        $user = auth()->user();

        // User ka role allowed roles mein nahi hai
        if (!in_array($user->role, $roles)) {
            abort(403, 'You are not authorized to access this page.');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Guest → go to login
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        // Logged in but wrong role → forbidden
        if (! in_array(auth()->user()->role, $roles)) {
            abort(403);
        }

        return $next($request);
    }
}

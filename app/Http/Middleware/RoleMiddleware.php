<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (! $user) {
            abort(403, 'Unauthorized.');
        }

        // Convert each $roles[] string to enum

        $allowed = array_map(function ($r) {
            $clean_r = trim($r);
            $lowercase_r = strtolower($clean_r);

            return UserRole::from($lowercase_r);
        }, $roles);

        if (!in_array($user->role, $allowed)) {
            abort(403, 'You do not have permission.');
        }

        return $next($request);
    }
}

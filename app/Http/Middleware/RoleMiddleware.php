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

        $allowedRoles = [];

        foreach ($roles as $role) {
            $allowedRole = UserRole::tryFrom(strtolower(trim($role)));

            if ($allowedRole) {
                $allowedRoles[] = $allowedRole;
            }
        }

        if (! in_array($user->role, $allowedRoles, true)) {
            abort(403, 'You do not have permission.');
        }

        return $next($request);
    }
}

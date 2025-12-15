<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{

    public function handle(Request $request, Closure $next, ...$roles): mixed
    {
        $user = Auth::user();

        if (!$user) {
            if ($request->is('api/*')) {
                return response()->json(['error' => 'Unauthorized'], 401);
            } else {
                abort(401, 'Unauthorized');
            }
        }

        if (!in_array($user->role, $roles)) {
            if ($request->is('api/*')) {
                return response()->json(['error' => 'Unauthorized'], 401);
            } else {
                return redirect(route('dashboard'));
            }
        }

        return $next($request);
    }
}

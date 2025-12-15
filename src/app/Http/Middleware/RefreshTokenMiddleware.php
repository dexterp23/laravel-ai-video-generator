<?php

namespace App\Http\Middleware;

use Closure;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use Illuminate\Http\Request;

class RefreshTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            try {
                $newToken = JWTAuth::parseToken()->refresh();
                $response = $next($request);
                return $response->header('Authorization', 'Bearer ' . $newToken);
            } catch (\Exception $ex) {
                return response()->json(['error' => 'Token expired'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}

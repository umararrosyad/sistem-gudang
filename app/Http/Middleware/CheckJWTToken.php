<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Exception;

class CheckJWTToken
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Cek apakah token ada dan valid
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            // Jika token tidak ada atau tidak valid
            if ($e instanceof TokenInvalidException) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Token is Invalid',
                    'data' => null
                ], 401);
            } else if ($e instanceof TokenExpiredException) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Token is Expired',
                    'data' => null
                ], 401);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Authorization Token not found',
                    'data' => null
                ], 401);
            }
        }

        return $next($request);
    }
}

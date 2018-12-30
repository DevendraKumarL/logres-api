<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch(Exception $exception) {
            switch(get_class($exception))
            {
                case \Tymon\JWTAuth\Exceptions\TokenExpiredException::class:
                    try {
                        $token = JWTAuth::parseToken()->refresh();
                        return response()->json([
                            'succcess' => false,
                            'error' => 'Token has expired',
                            'token' => $token
                        ], 401);
                    } catch(Exception $exception2) {
                        return response()->json([
                            'success' => false,
                            'error' => 'Token is blacklisted'
                        ], 401);
                    }
                case \Tymon\JWTAuth\Exceptions\TokenInvalidException::class:
                    return response()->json([
                        'success' => false,
                        'error' => 'Token is invalid'
                    ], 401);
                default:
                    return response()->json([
                        'success' => false,
                        'error' => 'Token not found'
                    ], 400);
            }
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

class RefreshToken
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
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json([
                    'code'     => 101,
                    'response' => null
                ]);
            }
        } catch (TokenExpiredException $e) {
            try {
                $refreshed = JWTAuth::refresh(true, true);
                $user      = JWTAuth::setToken($refreshed)->toUser();
                header('Authorization: Bearer ' . $refreshed);
            } catch (JWTException $e) {
                return response()->json([
                    'code'     => 103,
                    'response' => null
                ]);
            }
        } catch (JWTException $e) {
            return  $next($request);
        }

        Auth::login($user, false);

        return  $next($request);
    }
}

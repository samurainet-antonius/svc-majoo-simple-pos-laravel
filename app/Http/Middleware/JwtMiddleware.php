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
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json([
                    'code' => 401,
                    'message' => 'Token login tidak sesuai.'
                ],401);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json([
                    'code' => 401,
                    'message' => 'Token login sudah kadaluwarsa.'
                ],401);
            }else{
                return response()->json([
                    'code' => 401,
                    'message' => 'Pengguna tidak ditemukan.'
                ],401);
            }
        }
        return $next($request);
    }
}
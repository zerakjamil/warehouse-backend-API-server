<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\RateLimiter;

class RateLimiterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
//        $user = Auth::user();
//
//        if (RateLimiter::tooManyAttempts('send-message:'.$user->id, 10)) {
//            $time = RateLimiter::availableIn('send-message:'.$user->id);
//            return response()->json([
//                'status' => 'error',
//                'message' => 'Too many attempts, You may try again in '.$time.' seconds.'
//            ]);
//        }
//
//        RateLimiter::increment('send-message:'.$user->id,3600);

        return $next($request);
    }
}

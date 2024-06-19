<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class RateLimiterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $key = 'rate_limit:' . $user->id;
        $attempts = Cache::get($key, 0);
        if ($attempts >= 10){
            return response()->json([
                'status' => 'error',
                'message' => 'too many attempts please try again later!'
            ]);
        }
        Cache::put($key, $attempts + 1, now()->addMinutes(60));

        return $next($request);
    }
}

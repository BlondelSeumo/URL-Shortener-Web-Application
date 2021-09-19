<?php

namespace App\Http\Middleware;

use Closure;

class APIGuardMiddleware
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
        if ($request->user()->cannot('api', ['App\Link', $request->user()->plan->features->api])) {
            return response()->json([
                'message' => __('You don\'t have access to this feature.'),
                'status' => 403
            ], 403);
        }

        return $next($request);
    }
}

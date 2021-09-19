<?php

namespace App\Http\Middleware;

use Closure;

class LicenseMiddleware
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
        // Check if a license is present
        if (config('settings.license_key') === NULL || config('settings.license_type') === null) {
            return redirect()->route('admin.license');
        }

        return $next($request);
    }
}

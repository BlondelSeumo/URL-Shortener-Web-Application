<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class LocaleMiddleware
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
            // Get all the available languages
            $languages = config('app.locales');

            // If the user is authed
            if (Auth::check()) {
                // Get the user's locale
                $language = $request->user()->locale;

                if(array_key_exists($language, $languages)) {
                    app()->setLocale($language);
                } else {
                    app()->setLocale(config('app.locale'));
                }
            }
            // If a language has already been selected
            elseif($request->hasCookie('locale')) {
                // Get the current language
                $language = $request->cookie('locale');

                if(array_key_exists($language, $languages)) {
                    app()->setLocale($language);
                } else {
                    app()->setLocale(config('app.locale'));
                }
            }
            // Attempt to read the user's language preference
            elseif($request->server('HTTP_ACCEPT_LANGUAGE')) {
                $language = explode('-', $request->server('HTTP_ACCEPT_LANGUAGE'));

                if(array_key_exists($language[0], $languages)) {
                    app()->setLocale($language[0]);
                } else {
                    app()->setLocale(config('app.locale'));
                }
            }
            // Set the language to the default one
            else {
                app()->setLocale(config('app.locale'));
            }
        } catch (\Exception $e) {
        }

        return $next($request);
    }
}

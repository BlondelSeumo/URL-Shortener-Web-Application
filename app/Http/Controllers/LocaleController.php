<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocaleController extends Controller
{
    /**
     * Update the Locale preference.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateLocale(Request $request)
    {
        // Get all the available languages
        $languages = config('app.locales');

        // Get the selected language
        $language = $request->input('locale');

        // If the selected language exists
        if (array_key_exists($language, $languages)) {
            // Update the user's locale
            if(Auth::check()) {
                $request->user()->locale = $language;
                $request->user()->save();
            }
        }

        return redirect()->back()->withCookie('locale', $language, (60 * 24 * 365 * 10));
    }
}

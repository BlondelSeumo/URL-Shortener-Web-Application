<?php

namespace App\Rules;

use App\Domain;
use Illuminate\Contracts\Validation\Rule;

class ValidateDomainNameRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $url = parse_url(str_replace('://www.', '://', $value))['host'];
        } catch (\Exception $e) {
            return false;
        }

        // If the domain is the same with the installation URL
        if ($url == parse_url(config('app.url'))['host']) {
            return false;
        }

        if (Domain::where('name', '=', $url)->exists()) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('This domain is already being used.');
    }
}

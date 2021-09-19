<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateUrlsRule implements Rule
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
        // Get the URLs
        $urls = preg_split('/\n|\r/', $value, -1, PREG_SPLIT_NO_EMPTY);

        // Validate URLs
        foreach ($urls as $url) {
            // If the input contains an invalid url
            // or if the input exceeds 2048 characters
            if (!filter_var($url, FILTER_VALIDATE_URL) || mb_strlen($url) > 2048) {
                return false;
            }
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
        return __('validation.url');
    }
}

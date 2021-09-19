<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateDNSRule implements Rule
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
        $value = parse_url($value);

        // Check if the remote host points to the local host
        if (isset($value['host']) && getRemoteIp($value['host']) == getHostIp()) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('The DNS A record does not point to our server, or the DNS did not propagated yet, this can take up to 24 hours.');
    }
}

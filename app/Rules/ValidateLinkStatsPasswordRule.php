<?php

namespace App\Rules;

use App\Link;
use Illuminate\Contracts\Validation\Rule;

class ValidateLinkStatsPasswordRule implements Rule
{
    /**
     * The link id
     *
     * @var
     */
    private $link;

    /**
     * Create a new rule instance.
     *
     * @param $link
     * @return void
     */
    public function __construct($link)
    {
        $this->link = $link;
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
        $website = Link::where('id', '=', $this->link)->first();

        if ($website->privacy_password == $value) {
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
        return __('The entered password is not correct.');
    }
}

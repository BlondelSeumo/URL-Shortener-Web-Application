<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateUrlsCountRule implements Rule
{
    /**
     * @var
     */
    protected $count;

    /**
     * Create a new rule instance.
     *
     * @param int $count
     */
    public function __construct($count = 10)
    {
        // Maximum number of URLs to be shortened
        $this->count = $count;
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
        // Count the number of URLs to be shortened
        if (count(preg_split('/\n|\r/', $value, -1, PREG_SPLIT_NO_EMPTY)) > $this->count) {
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
        return __('You can\'t shorten more than :count links at once.', ['count' => $this->count]);
    }
}

<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UploadLanguageRule implements Rule
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
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Read the file's contents
        $uploadedFile = file_get_contents($value);
        $file = json_decode($uploadedFile);

        // Validate the file
        if (isset($file->lang_code) == false || isset($file->lang_name) == false || isset($file->lang_dir) == false) {
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
        return __('Invalid language file.');
    }
}

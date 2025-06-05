<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateDays implements Rule
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
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $from = json_decode(request()->from)->unix;
            $to = json_decode(request()->to)->unix;
        } catch (\Exception $e) {
            return false; // JSON decode failed, so the format is invalid
        }
        $diff = ($to - $from) / (1000 * 60 * 60 * 24);

        return ($diff <= 1) && ($from != $to);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'End date cannot be either the same as or two days ahead of start date';
    }
}

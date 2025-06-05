<?php


namespace App\Filament\Resources\UserResource\Pages;


use Closure;

class Rule
{
    /**
     * @return Closure
     */
    public static function validateName(): Closure
    {
        return function () {
            return function (string $attribute, $value, Closure $fail) {
                if (!preg_match('/^[a-zA-Z0-9 ]*$/u', $value)) {
                    $fail("Change the language by pressing (ALT+SHIFT).");
                }
            };
        };
    }

    /**
     * @return Closure
     */
    public static function validateEmail(): Closure
    {
        return function () {
            return function (string $attribute, $value, Closure $fail) {
                if (preg_match('/@(persoreco\.com|solsuntrading\.com|persolco\.com|bazorg\.com)$/i', $value)) {
                    return true;
                }
                $fail("The email given is invalid.");
            };
        };
    }

    /**
     * @return Closure
     */
    public static function validatePassword(): Closure
    {
        return function () {
            return function (string $attribute, $value, Closure $fail) {
                if (strlen($value) < 8) {
                    $fail("Password cannot be less than 8 characters.");
                }
            };
        };
    }
}

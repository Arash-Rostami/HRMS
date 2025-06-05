<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidateEnglishChar extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('englishChar', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[a-zA-Z0-9 !@#$%^&*()\-_=+\[\]{}|;:\'",.<>\/?]*$/', $value);
        });

        Validator::replacer('englishChar', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'This field must contain English alphabet characters only.');
        });
    }
}

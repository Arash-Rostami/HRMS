<?php


namespace App\Filament\Resources\ParkResource\Pages;


use App\Filament\Resources\DashboardResource\Form as ParkForm;
use App\Filament\Resources\DashboardResource\Validation;
use App\Models\Park;
use Closure;
use Filament\Resources\Pages\Page;

class Rule
{
    /**
     * @return Closure
     */
    public static function validateNumber(): Closure
    {
        return function (Closure $get, Page $livewire) {
            if ($livewire instanceof EditPark) return null;
            return function (string $attribute, $value, Closure $fail) use ($get) {
                $form = new ParkForm($get);
                $validator = new Validation(new Park(), $form);
                if ($get('state') == 'active') {
                    if (!$validator->isPaused($form)) {
                        if ($validator->isPlaceBooked()) return $fail($form->errors['booking']);
                    }
                    if ($validator->hasUserBooked()) return $fail($form->errors['reservation']);
                }
            };
        };
    }


    /**
     * @return Closure
     */
    public static function validateYear(): Closure
    {
        return function (Closure $get, Page $livewire) {
            return function (string $attribute, $value, Closure $fail) use ($get, $livewire) {
                if ($get('start_year') > $get('end_year')) return $fail('End year cannot be behind start year!');
            };
        };
    }

    /**
     * @return Closure
     */
    public static function validateMonth(): Closure
    {
        return function (Closure $get, Page $livewire) {
            return function (string $attribute, $value, Closure $fail) use ($get, $livewire) {
                if ($get('start_year') == $get('end_year')) {
                    if ($get('start_month') > $get('end_month')) return $fail('End month cannot be behind start month!');
                }
            };
        };
    }

    /**
     * @return Closure
     */
    public static function validateDay(): Closure
    {
        return function (Closure $get, Page $livewire) {
            return function (string $attribute, $value, Closure $fail) use ($get, $livewire) {
                if ($get('start_year') == $get('end_year') && $get('start_month') == $get('end_month')) {
                    if ($get('start_day') > $get('end_day')) return $fail('End month cannot be behind start month!');
                }
            };
        };
    }

    /**
     * @return Closure
     */
    public static function validateState(): Closure
    {
        return function (Closure $get, Page $livewire) {
            return function (string $attribute, $value, Closure $fail) use ($get, $livewire) {
                $form = new ParkForm($get);
                $validator = new Validation(new Park(), $form);
                if ($value == 'active') {

                    if ($livewire instanceof EditPark && $validator->isBooking('office')) return $fail($form->errors['space']);
                    if (!$validator->isPaused($form)) {
                        if ($validator->isPlaceBooked()) return $fail($form->errors['booking']);
                    }
                    if ($validator->hasUserBooked()) return $fail($form->errors['reservation']);
                }
            };
        };
    }

    /**
     * @return Closure
     */
    public static function validateUser(): Closure
    {
        return function (Closure $get, Page $livewire) {
            return function (string $attribute, $value, Closure $fail) use ($get, $livewire) {
                $form = new ParkForm($get);
                $validator = new Validation(new Park(), $form);

                if ($livewire instanceof CreatePark && $validator->isBooking('office')) return $fail($form->errors['space']);
                if ($validator->isUserSuspended()) return $fail($form->errors['suspension']);
            };
        };
    }
}

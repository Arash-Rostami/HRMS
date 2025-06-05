<?php

namespace App\Filament\Resources\CancellationResource\Pages;

use App\Filament\Resources\DashboardResource\Form as CancellationForm;
use App\Filament\Resources\DashboardResource\Validation;
use App\Models\Cancellation;
use Closure;
use Filament\Resources\Pages\Page;
use App\Filament\Resources\DashboardResource\Form;


class Rule
{

    /**
     * @return Closure
     */
    public static function validateStartDay(): Closure
    {
        return function (Closure $get, Page $livewire) {
            return function (string $attribute, $value, Closure $fail) use ($get, $livewire) {
                $form = new Form($get);
                $validator = new Validation(new Cancellation(), $form);
                if ($validator->isExtra($form, $get('number'))) return $fail($form->errors['cancellation_conflict']);
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
                    if ($get('start_day') > $get('end_day')) return $fail('End day cannot be the same or behind end month!');
                }
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
    public static function validateNumber(): Closure
    {
        return function (Closure $get, Closure $set, Page $livewire) {
            return function (string $attribute, $value, Closure $fail) use ($get, $set, $livewire) {
                $set('start_hour', '00 00:00:00');
                $set('end_hour', '00 00:00:00');
                $form = new CancellationForm($get);
                $validator = new Validation(new Cancellation(), $form);
                if ($validator->hasUserCancelled()) return $fail($form->errors['cancellation_exists']);
            };
        };

    }
}

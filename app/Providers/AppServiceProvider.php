<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('future_date', function ($attribute, $value, $parameters, $validator) {
            $value = Carbon::create($value);
            $days = isset($parameters[0]) ? intval($parameters[0]) : 0;
            $today = Carbon::now();
            return $value->greaterThan($today) && $today->diffInDays($value) >= $days;
        });

        Validator::replacer('future_date', function ($message, $attribute, $rule, $parameters) {
            $days = isset($parameters[0]) ? intval($parameters[0]) : 0;
            return str_replace(':attribute', $attribute, str_replace(':days', $days, 'The :attribute must be a date greater than today or up to :days days in the future.'));
        });
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->date_greater_than();
    }

    private function date_greater_than()
    {
        Validator::extend('date_greater_than', function ($attribute, $value, $parameters, $validator) {
            $first = Carbon::parse($value);
            $second = Carbon::parse($parameters[0]);
            return $first->greaterThan($second);
        }, "La data di fine deve essere maggiore della data di inizio");
    }
}

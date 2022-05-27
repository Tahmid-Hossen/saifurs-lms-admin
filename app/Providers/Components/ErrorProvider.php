<?php

namespace App\Providers\Components;

use Form;
use Illuminate\Support\ServiceProvider;

class ErrorProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Loading All Error Style
     */
    public function boot()
    {
        Form::macro('nError', function ($name, $msg = null) {

            return '<span id="' . $name . '-error" class="d-block  help-block text-danger">' . $msg . '</span>';
        });

        Form::macro('hError', function ($name, $msg = null) {

            return '<span id="' . $name . '-error" class="d-block  help-block text-danger">' . $msg . '</span>';
        });

        Form::macro('fError', function ($name, $msg = null) {

            return '<span id="' . $name . '-error" class="d-block  help-block text-danger">' . $msg . '</span>';
        });
    }
}

<?php

namespace App\Providers\Components;

use Form;
use Illuminate\Support\ServiceProvider;

class LabelProvider extends ServiceProvider
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
     * Loading All Label Style
     */
    public function boot()
    {
        Form::macro('nLabel', function ($name, $value, $required = false, $options = []) {

            if ($required) {
                $value .= '<span style="color: #dd4b39; font-weight:700">*</span>';
            }

            return Form::label($name, $value, $options, false);
        });

        Form::macro('hLabel', function ($name, $value, $required = false, $col_size = 2, $options = []) {

            if ($required) {
                $value .= '<span style="color: #dd4b39; font-weight:700">*</span>';
            }

            return Form::label($name, $value, array_merge(['class' => "col-md-$col_size col-form-label"], $options), false);
        });
        Form::macro('fLabel', function ($name, $value, $required = false, $options = []) {

            if ($required) {
                $value .= '<span style="color: #dd4b39; font-weight:700">*</span>';
            }

            return str_replace('label', 'span', Form::label($name, $value, $options, false));
        });
    }
}

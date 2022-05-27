<?php

namespace App\Providers\Components;

use Form;
use Illuminate\Support\HtmlString;
use Illuminate\Support\ServiceProvider;

class HorizontalFieldProvider extends ServiceProvider
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

    public function boot()
    {
        //       Horizontal Form   start

        /**
         * @parem string $name
         * @parem string $label
         * @parem mixed $default
         * @parem bool $required
         * @parem array $attributes
         */
        Form::component('hText', 'form.horizon.text', ['name', 'label', 'default' => null, 'required' => false, 'col_size' => 2, 'attributes' => []]);
        /**
         * @parem string $name
         * @parem string $label
         * @parem mixed $default
         * @parem bool $required
         * @parem array $attributes
         */
        Form::component('hEmail', 'form.horizon.email', ['name', 'label', 'default' => null, 'required' => false, 'col_size' => 2, 'attributes' => []]);


        /**
         * @parem string $name
         * @parem string $label
         * @parem bool $required
         * @parem array $attributes
         */
        Form::component('hSearch', 'form.horizon.search', ['name', 'label', 'default' => null, 'required' => false, 'col_size' => 2, 'attributes' => []]);

        /**
         * @parem string $name
         * @parem string $label
         * @parem bool $required
         * @parem array $attributes
         */
        Form::component('hTel', 'form.horizon.tel', ['name', 'label', 'default' => null, 'required' => false, 'col_size' => 2, 'attributes' => []]);

        /**
         * @parem string $name
         * @parem string $label
         * @parem bool $required
         * @parem array $attributes
         */
        Form::component('hNumber', 'form.horizon.number', ['name', 'label', 'default' => null, 'required' => false, 'col_size' => 2, 'attributes' => []]);


        /**
         * @parem string $name
         * @parem string $label
         * @parem bool $required
         * @parem array $attributes
         */
        Form::component('hDate', 'form.horizon.date', ['name', 'label', 'default' => null, 'required' => false, 'col_size' => 2, 'attributes' => []]);

        /**
         * @parem string $name
         * @parem string $label
         * @parem bool $required
         * @parem array $attributes
         */
        Form::component('hUrl', 'form.horizon.url', ['name', 'label', 'default' => null, 'required' => false, 'col_size' => 2, 'attributes' => []]);

        /**
         * @parem string $name
         * @parem string $label
         * @parem bool $required
         * @parem array $attributes
         */
        Form::component('hFile', 'form.horizon.file', ['name', 'label', 'default' => null, 'required' => false, 'col_size' => 2, 'attributes' => []]);


        /**
         * @parem string $name
         * @parem string $label
         * @parem bool $required
         * @parem array $attributes
         */
        Form::component('hTextarea', 'form.horizon.textarea', ['name', 'label', 'default' => null, 'required' => false, 'col_size' => 2, 'attributes' => []]);


        /**
         * Create a select box field.
         *
         * @param string $name
         * @param array $list
         * @param string|bool $selected
         * @param array $selectAttributes
         * @param array $optionsAttributes
         * @param array $optgroupsAttributes
         */
        Form::component('hSelect', 'form.horizon.select', ['name', 'label', 'data', 'selected' => null, 'required' => false, 'col_size' => 2, 'attributes' => []]);

        /**
         * Create a select range field.
         *
         * @param string $name
         * @param string $begin
         * @param string $end
         * @param string $selected
         * @param array $options
         *
         * @return HtmlString
         */
        Form::component('hSelectRange', 'form.horizon.selectrange', ['name', 'label', 'begin', 'end', 'selected' => null, 'required' => false, 'col_size' => 2, 'attributes' => []]);


        /**
         * Create a select year field.
         *
         * @param string $name
         * @param string $begin
         * @param string $end
         * @param string $selected
         * @param array $options
         *
         * @return mixed
         */
        Form::component('hSelectYear', 'form.horizon.selectyear', ['name', 'label', 'begin', 'end', 'selected' => null, 'required' => false, 'col_size' => 2, 'attributes' => []]);


        /**
         * Create a select month field.
         *
         * @param string $name
         * @param string $selected
         * @param array $options
         * @param string $format
         *
         * @return HtmlString
         */
        Form::component('hSelectMonth', 'form.horizon.selectmonth', ['name', 'label', 'selected' => null, 'required' => false, 'col_size' => 2, 'attributes' => []]);


        /**
         * Create a checkbox input field.
         *
         * @param string $name
         * @param mixed $value
         * @param bool $checked
         * @param array $options
         *
         * @return HtmlString
         */
        Form::component('hCheckbox', 'form.horizon.checkbox', ['name', 'label', 'checked', 'required' => false, 'col_size' => 2, 'attributes' => []]);


        /**
         * Create a radio button input field.
         *
         * @param string $name
         * @param mixed $value
         * @param bool $checked
         * @param array $options
         *
         * @return HtmlString
         */
        Form::component('hRadio', 'form.horizon.radio', ['name', 'label', 'checked' => null, 'required' => false, 'col_size' => 2, 'attributes' => []]);
    }
}

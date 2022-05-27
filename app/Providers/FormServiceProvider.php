<?php

namespace App\Providers;

use App\Providers\Components\ErrorProvider;
use App\Providers\Components\GroupFieldProvider;
use App\Providers\Components\HorizontalFieldProvider;
use App\Providers\Components\LabelProvider;
use App\Providers\Components\NormalFieldProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Form';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'form';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(ErrorProvider::class);
        $this->app->register(LabelProvider::class);
        $this->app->register(NormalFieldProvider::class);
        $this->app->register(HorizontalFieldProvider::class);
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
}

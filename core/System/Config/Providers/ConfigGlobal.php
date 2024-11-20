<?php

namespace Vsw\Config\Providers;

use Illuminate\Support\ServiceProvider;
use Vsw\Config\ConfigGl;

class ConfigGlobal extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('cfglobal', function () {
            return new ConfigGl();
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

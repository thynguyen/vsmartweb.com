<?php

namespace Core\Providers;

use Illuminate\Support\ServiceProvider;
use Core\Ckediter;

class CkediterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('ckediter', function () {
            return new Ckediter();
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

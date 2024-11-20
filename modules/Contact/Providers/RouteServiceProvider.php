<?php

namespace Modules\Contact\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use File;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $moduleNamespace = 'Modules\Contact\Http\Controllers';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapAdminRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        if (File::exists(module_path('Contact', '/Routes/web.php'))) {

            Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','theme:theme','CoreMW\RunWidget','CoreMW\CheckWebMod:Contact','CoreMW\CloseSite']], function () {
                Route::namespace($this->moduleNamespace)
                    ->group(module_path('Contact', '/Routes/web.php'));
            });
        }
    }
    protected function mapAdminRoutes()
    {
        if (File::exists(module_path('Contact', '/Routes/admin.php'))) {
            Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','theme:admintheme','CoreMW\checkAdminLogin','CoreMW\CheckMod:Contact']], function () {
                Route::prefix(config('app.prefixadmin','admin'))
                    ->middleware('web')
                    ->namespace($this->moduleNamespace)
                    ->group(module_path('Contact', '/Routes/admin.php'));
            });
        }
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        if (File::exists(module_path('Contact', '/Routes/api.php'))) {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->moduleNamespace)
                ->group(module_path('Contact', '/Routes/api.php'));
        }
    }
}

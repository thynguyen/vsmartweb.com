<?php

namespace Modules\Members\Providers;

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
    protected $moduleNamespace = 'Modules\Members\Http\Controllers';

    // protected $urllang = '';

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

        $this->mapSiteMapRoutes();
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
        if (File::exists(module_path('Members', '/Routes/web.php'))) {
            Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','theme:theme','CoreMW\RunWidget','CoreMW\CheckWebMod:Members','CoreMW\CloseSite']], function () {
                    Route::namespace($this->moduleNamespace)
                        ->group(module_path('Members', '/Routes/web.php'));

            });
        }
    }

    
    protected function mapAdminRoutes()
    {
        if (File::exists(module_path('Members', '/Routes/admin.php'))) {

            Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','theme:admintheme','CoreMW\checkAdminLogin','CoreMW\CheckMod:Members']], function () {
                Route::prefix(config('app.prefixadmin','admin'))
                    ->namespace($this->moduleNamespace)
                    ->group(module_path('Members', '/Routes/admin.php'));

            });
        }
    }

    protected function mapSiteMapRoutes()
    {
        if (File::exists(module_path('Members', '/Routes/sitemap.php'))) {
            Route::middleware('web')
                ->namespace($this->moduleNamespace)
                ->group(module_path('Members', '/Routes/sitemap.php'));
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
        if (File::exists(module_path('Members', '/Routes/api.php'))) {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->moduleNamespace)
                ->group(module_path('Members', '/Routes/api.php'));
        }
    }
}

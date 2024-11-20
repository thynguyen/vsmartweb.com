<?php

namespace Core\Providers;

use Illuminate\Support\ServiceProvider;
use Core\AdminFunctions;
use File;

class AdminFuncServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('adminfunctions', function () {
            return new AdminFunctions();
        });

        $baseroutes = base_path('core/System');
        $listroutes = array_map('basename', File::directories($baseroutes));
        foreach ($listroutes as $routessys) {
            if(file_exists($baseroutes.'/'.$routessys.'/routes/admin.php')) {
                $this->loadRoutesFrom($baseroutes.'/'.$routessys.'/routes/admin.php');
            }
            if(file_exists($baseroutes.'/'.$routessys.'/routes/web.php')) {
                $this->loadRoutesFrom($baseroutes.'/'.$routessys.'/routes/web.php');
            }
            if (File::exists($baseroutes.'/'.$routessys.'/routes/api.php')) {
                $this->loadRoutesFrom($baseroutes.'/'.$routessys.'/routes/api.php');
            }

            if (File::exists($baseroutes.'/'.$routessys.'/lang')) {
                $this->loadTranslationsFrom($baseroutes.'/'.$routessys.'/lang', $routessys);
            }
        }
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

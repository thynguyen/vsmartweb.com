<?php

namespace Vsw\Modules\Providers;
// use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Vsw\Modules\ModulesFunc;
use File,Theme,CFglobal;

class ModulesServiceProvider extends ServiceProvider{

    private $configFile = [];

    public function register()
    {
        // register your config file here
        foreach ($this->configFile as $alias => $path) {
            $this->mergeConfigFrom(__DIR__ . "/" . $path, $alias);
        }
    }
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        $this->app->singleton('managermodule', function () {
            return new ModulesFunc();
        });
        // $basemod = base_path('modules');
        // $directories = array_map('basename', File::directories($basemod));
        // foreach ($directories as $moduleName) {
        //     $this->_registerModule($moduleName,$basemod);
        // }
    }
    private function _registerModule($moduleName,$basemod) {
        // $modulePath = $basemod . '/'.$moduleName.'/';
        // $files = glob($modulePath.'Routes/*.php');
        // $files = array_reverse($files);
        // $files = array_filter($files, 'is_file');
        // if (is_array($files)) {
        //     foreach ($files as $k => $file) {
        //         if (File::exists($modulePath .'Routes/'. basename($file))) {
        //             $this->loadRoutesFrom($modulePath .'Routes/'. basename($file));
        //         }
        //     }
        // }
        // // boot languages
        // if (File::exists($modulePath . 'Resources/lang')) {
        //     $this->loadTranslationsFrom($modulePath . 'Resources/lang', $moduleName);
        // }
        // // boot views
        // if (File::exists($modulePath . 'Resources/views')) {
        //     $this->loadViewsFrom($modulePath . 'Resources/views', $moduleName);
        // }
    }
}

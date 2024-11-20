<?php

namespace Vsw\Themes\Providers;

// use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Vsw\Themes\ThemesFunc;
use Vsw\Themes\Console\WidgetMakeCommand;
use Vsw\Themes\Factories\AsyncWidgetFactory;
use Vsw\Themes\Factories\WidgetFactory;
use Vsw\Themes\WidgetGroupCollection;
use Vsw\Themes\Misc\LaravelApplicationWrapper;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\Support\Facades\Schema;
use File,Theme,CFglobal,Comments,LanguageFunc,AdminFunc;
use PDOException;
use Vsw\Themes\BladeRouteGeneratorSys;

class ThemesServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('managertheme', function () {
            return new ThemesFunc();
        });

        $core = base_path('core/routes/');
        $fileroutes = glob($core.'*.php');
        $fileroutes = array_reverse($fileroutes);
        $fileroutes = array_filter($fileroutes, 'is_file');
        foreach ($fileroutes as $file) {
            $file_name = basename($file);
            if(file_exists($core.$file_name)) {
                include $core.$file_name;
            }
        }
        if(is_dir(base_path('core').'/Views')) {
            $this->loadViewsFrom(base_path('core').'/Views', 'Core');
        }

        $basetheme = base_path('Themes');
        $listTheme = array_map('basename', File::directories($basetheme));
        foreach ($listTheme as $theme) {
            if(file_exists($basetheme.'/'.$theme.'/routes.php')) {
                include $basetheme.'/'.$theme.'/routes.php';
            }
            // boot languages
            if (file_exists($basetheme.'/'.$theme.'/lang')) {
                $this->loadTranslationsFrom($theme . 'lang', $theme);
            }
            if (file_exists($basetheme.'/'.$theme.'/assets')) {
                $this->loadTranslationsFrom($theme . 'assets', $theme);
            }
            // boot views
            if(is_dir($basetheme.'/'.$theme.'/views')) {
                $this->loadViewsFrom($basetheme.'/'.$theme.'/views', $theme);
            }
        }
        if(file_exists(base_path('core/Foundation/rlc').'/rlc.php')) {
            include base_path('core/Foundation/rlc').'/rlc.php';
        }
        try {
            DB::connection()->getPdo();
            if (DB::connection()->getDatabaseName() && Schema::hasTable('vsw_config')) {
                if (File::exists($basetheme.'/'.CFglobal::cfn('theme').'/theme.php') && !is_null(CFglobal::cfn('theme'))) {
                    $this->loadRoutesFrom($basetheme.'/'.CFglobal::cfn('theme').'/theme.php');
                }
            }
        } catch (\Exception $e) {
            // die("Could not open connection to database server.  Please check your configuration.");
            return false;
        }

        $routeConfig = [
            'namespace'  => 'Vsw\Themes\Controllers',
            'prefix'     => 'vswwidget',
            'middleware' => ['web'],
        ];

        if (!$this->app->routesAreCached()) {
            $this->app['router']->group($routeConfig, function ($router) {
                $router->get('load-widget', 'WidgetController@showWidget');
            });
        }

        Blade::directive('LinkTheme', function () {
            return "<?php echo ThemesFunc::LinkTheme(); ?>";
        });
        Blade::directive('ScriptTheme', function ($expression='null') {
            return "<?php echo ThemesFunc::ScriptTheme($expression); ?>";
        });
        Blade::directive('WidgetPlace', function ($expression) {
            return "<?php echo ThemesFunc::WidgetLoca($expression); ?>";
        });
        Blade::directive('ModuleLayout', function () {
            return "<?php echo ThemesFunc::ShowLayout(); ?>";
        });
        Blade::directive('widget', function ($expression) {
            return "<?php echo app('vswwidget.widget')->run($expression); ?>";
        });
        Blade::directive('asyncWidget', function ($expression) {
            return "<?php echo app('vswwidget.async-widget')->run($expression); ?>";
        });
        Blade::directive('widgetGroup', function ($expression) {
            return "<?php echo app('vswwidget.widget-group-collection')->group($expression)->display(); ?>";
        });
        Blade::directive('CapchaSite', function () {
            return "<?php echo ThemesFunc::Capcha(); ?>";
        });
        Blade::directive('LangCurrent', function ($expression) {
            return "<?php echo LanguageFunc::GetLangCurrent(app()->getLocale(),$expression); ?>";
        });
        Blade::directive('RoutesSys', function ($group) {
            return "<?php echo app('" . BladeRouteGeneratorSys::class . "')->generate({$group}); ?>";
        });

        Blade::directive('seoCheckKeyword', function ($model) {
            return "<?php echo AdminFunc::CheckKeyword($model); ?>";
        });
    }
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('vswwidget.widget', function () {
            return new WidgetFactory(new LaravelApplicationWrapper());
        });

        $this->app->bind('vswwidget.async-widget', function () {
            return new AsyncWidgetFactory(new LaravelApplicationWrapper());
        });
        $this->app->singleton('vswwidget.widget-group-collection', function () {
            return new WidgetGroupCollection(new LaravelApplicationWrapper());
        });
        $this->app->singleton('vswwidget.widget-namespaces', function () {
            return new NamespacesRepository();
        });

        $this->app->singleton('command.widget.make', function ($app) {
            return new WidgetMakeCommand($app['files']);
        });

        $this->commands('command.widget.make');
        $this->app->alias('vswwidget.widget', 'Vsw\Themes\Factories\WidgetFactory');
        $this->app->alias('vswwidget.async-widget', 'Vsw\Themes\Factories\AsyncWidgetFactory');
        $this->app->alias('vswwidget.widget-group-collection', 'Vsw\Themes\WidgetGroupCollection');
    }
    public function provides()
    {
        return ['vswwidget.widget', 'vswwidget.async-widget'];
    }
}

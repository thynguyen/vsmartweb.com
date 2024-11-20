<?php

namespace Installer\Providers;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Routing\Router;
use Livewire\Livewire;
use File,Theme,CFglobal;
use Installer\InstallerFunc;

class InstallerServiceProvider extends ServiceProvider
{
	public function boot()
    {
		if(is_dir(base_path('core').'/System/Installer/Views')) {
	        $this->loadViewsFrom(base_path('core').'/System/Installer/Views', 'installer');
	    }
	    if(file_exists(base_path('core').'/System/Installer/Config/config.php')) {
		    $this->mergeConfigFrom(base_path('core').'/System/Installer/Config/config.php','installer');
		}
	    Blade::directive('GetMenu', function ($number='null') {
            return "<?php echo Installer\InstallerFunc::getmenu($number); ?>";
        });
	}
}
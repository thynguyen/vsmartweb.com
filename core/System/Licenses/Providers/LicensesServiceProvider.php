<?php

namespace Vsw\Licenses\Providers;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Routing\Router;
use Livewire\Livewire;
use File,Theme,CFglobal;

class LicensesServiceProvider extends ServiceProvider
{
	public function boot()
    {
		if(is_dir(base_path('core').'/System/Licenses/Views')) {
	        $this->loadViewsFrom(base_path('core').'/System/Licenses/Views', 'licenses');
	    }
	 //    if(file_exists(base_path('core').'/System/Installer/Config/config.php')) {
		//     $this->mergeConfigFrom(base_path('core').'/System/Installer/Config/config.php','installer');
		// }
        Livewire::component('listversions', \Vsw\Licenses\Livewire\ListVersions::class);
	}
}
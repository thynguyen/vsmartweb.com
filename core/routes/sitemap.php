<?php
Route::group(['middleware' => ['CoreMW\CloseSite']], function () {
	Route::get('sitemap.xml', function()
	{
	    $sitemap = App::make("sitemap");

    	$allmodules = array_keys(Module::allEnabled());
    	foreach ($allmodules as $module) {
    		if (AdminFunc::ReturnModule($module,'active')==1 && File::exists(module_path($module, '/Routes/sitemap.php'))) {
        		include module_path($module, '/Routes/sitemap.php');
                foreach ($sitemapmod as $map) {
                	$sitemap->addSitemap(URL::to($map));
                }
            }
	    }

	    return $sitemap->render('sitemapindex');
	});
});
<?php
Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','theme:admintheme']], function () {
	Route::prefix(config('app.prefixadmin','admin'))->group(function(){
		$namespace = 'Vsw\Modules\Controllers';
		Route::group(['namespace' => $namespace, 'middleware' => ['CoreMW\checkAdminLogin','CoreMW\CheckAdmin:Modules']],function(){
			Route::group(['prefix'=>'modules'],function(){
				Route::get('', 'ModulesController@index')->name('listmodules');
				Route::get('addmodule', 'ModulesController@AddModule')->name('addmodule');
				Route::get('infomod/{module}', 'ModulesController@InstallModule')->name('infomod');
				Route::post('infomod/{module}', 'ModulesController@PostInstallModule');
				Route::post('reinstallmod','ModulesController@reinstallmod')->name('reinstallmod');
				Route::post('uninstallmod', 'ModulesController@UninstallModule')->name('uninstallmod');
				Route::post('active/{module}', 'ModulesController@ActiveModule')->name('activemod');
				Route::post('delmod/{module}', 'ModulesController@DeleteModule')->name('delmod');
				Route::post('upzipmod', 'ModulesController@UnzipModule')->name('upzipmod');
			});
		});
	});
});
Breadcrumbs::for('admin_index_modules', function ($trail) {
    $trail->parent('admin_dashboard');
    $trail->push(trans('Langcore::modules.mainModule'), route('listmodules'));
});
Breadcrumbs::for('admin_infomod_modules', function ($trail,$trans,$module) {
    $trail->parent('admin_index_modules');
    $trail->push($trans, route('infomod',$module));
});
Breadcrumbs::for('admin_add_modules', function ($trail) {
    $trail->parent('admin_index_modules');
    $trail->push(trans('Langcore::modules.AddModule'), route('addmodule'));
});
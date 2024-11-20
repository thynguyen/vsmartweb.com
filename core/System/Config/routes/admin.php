<?php

Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','theme:admintheme']], function () {
	Route::prefix(config('app.prefixadmin','admin'))->group(function(){
		$namespace = 'Vsw\Config\Controllers';
		Route::group(['module'=>'Admin', 'namespace' => $namespace], function() {
			Route::group(['middleware' => ['CoreMW\checkAdminLogin','CoreMW\CheckAdmin:Config']],function(){
				Route::group(['prefix'=>'config'],function(){
					Route::get('', 'ConfigController@cfredirect')->name('config');
					Route::get('siteconfig', 'ConfigController@config');
					Route::post('siteconfig', 'ConfigController@siteConfig')->name('siteconfig');
					Route::get('globalconfig', 'ConfigController@globalconfig')->name('globalconfig');
					Route::post('globalconfig', 'ConfigController@PostGlobalConfig');
					Route::get('configimg/{namedata}', 'ConfigController@configimg')->name('configimg');
					Route::post('uploadimg/{namedata}', 'ConfigController@Uploadimg')->name('uploadimg');
					Route::get('getlisticon/{idkey}/{name}/{valdata?}','ConfigController@getlisticon')->name('getlisticon');
					Route::get('updatecore','ConfigController@updatecore')->name('updatecore');
				});
			});
		});
	});
});

Breadcrumbs::for('admin_configsite', function ($trail) {
    $trail->parent('admin_dashboard');
    $trail->push(lang('content.config_site'), route('siteconfig'));
});

Breadcrumbs::for('admin_configglobal', function ($trail) {
    $trail->parent('admin_dashboard');
    $trail->push(lang('content.config_global'), route('globalconfig'));
});

Breadcrumbs::for('admin_updatecore', function ($trail) {
    $trail->parent('admin_dashboard');
    $trail->push(trans('Langcore::config.Update'), route('updatecore'));
});
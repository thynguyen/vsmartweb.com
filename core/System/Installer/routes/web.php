<?php
Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','Installer\Middleware\FinishInstaller']], function () {
	$namespace = 'Installer\Controllers';
	Route::group(['prefix' => 'install','namespace' => $namespace], function() {
		Route::name('installer.web.')->group(function () {
			Route::get('','InstallerController@main')->name('main');
			Route::post('checklicense','InstallerController@checklicense')->name('checklicense');
			Route::group(['middleware' => ['Installer\Middleware\RegisteredLicense']], function () {
				Route::get('requirements','InstallerController@requirements')->name('requirements');
				Route::get('permissions','InstallerController@permissions')->name('permissions');

				Route::get('database','InstallerController@database')->name('database');
				Route::post('database','InstallerController@postdatabase');
				Route::get('migratedata','InstallerController@migratedata')->name('migratedata');

				Route::get('configenv','InstallerController@configenv')->name('configenv');
				Route::post('configenv','InstallerController@postconfigenv');

				Route::get('createadmin','InstallerController@createadmin')->name('createadmin');
				Route::post('createadmin','InstallerController@postcreateadmin');

				Route::get('finish','InstallerController@finish')->name('finish');
				Route::post('finish','InstallerController@postfinish');
			});
		});
	});
});
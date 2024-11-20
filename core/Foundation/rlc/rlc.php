<?php

Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {
	$namespace = 'Core\Controllers';
	Route::group(['module'=>'Admin', 'namespace' => $namespace,'prefix'=>'vswwarning'], function() {
		Route::name('license.admin.')->group(function () {
			Route::get('expiration','RLCController@expiration')->name('expiration');
			Route::get('notlicense','RLCController@notlicense')->name('notlicense');
			Route::get('suspended','RLCController@suspended')->name('suspended');
			Route::get('notdomainlicense','RLCController@notdomainlicense')->name('notdomainlicense');
		});
		Route::get('closesite','RLCController@closesite')->name('closesite');
	});
});
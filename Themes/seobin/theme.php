<?php

Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','theme:theme','CoreMW\BlockIP','CoreMW\RunWidget','CoreMW\CloseSite','CoreMW\CloseSite']], function () {
	$namespace = 'Themes\\'.CFglobal::cfn('theme').'\Controllers';
	Route::group(['namespace' => $namespace], function() {
		if (is_null(CFglobal::cfn('moddefault')) || CFglobal::cfn('moddefault') == 'Index-Home') {
			Route::get('','SeoBinController@indexHome')->name('indexhome');
		}
	});
});
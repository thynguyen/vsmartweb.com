<?php

Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','theme:theme','CoreMW\RunWidget','CoreMW\CloseSite']], function () {
	$namespace = 'Core\Controllers';
	Route::group(['namespace' => $namespace], function() {

        if((CFglobal::cfn('theme') == 'default' || !File::exists(base_path('Themes').'/'.CFglobal::cfn('theme').'/theme.php')) && (is_null(CFglobal::cfn('moddefault')) || CFglobal::cfn('moddefault') == 'Index-Home') ){
			Route::get('','HomeController@indexHome')->name('indexhome');
        }
	});
});
Breadcrumbs::for('sitehome', function ($trail) {
    $trail->push(trans('Langcore::global.home'), route('indexhome'));
});
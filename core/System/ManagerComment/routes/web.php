<?php
Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','theme:theme','CoreMW\RunWidget']], function () {
	$namespace = 'Vsw\Comment\Controllers';
	Route::group(['namespace' => $namespace], function() {
		Route::post('comments/{module}', 'CommentController@store')->name('comments.store');
	});
});
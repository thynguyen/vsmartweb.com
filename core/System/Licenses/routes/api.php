<?php

use Illuminate\Http\Request;
$namespace = 'Vsw\Licenses\Controllers';
Route::group(['namespace' => $namespace,'prefix' => 'api', 'middleware' => 'api'], function () {
	Route::group(['prefix'=>'licenses'],function(){
		Route::name('licenses.api.')->group(function () {
			Route::get('','LicensesApiController@licence')->name('licence');
			Route::post('checklicence','LicensesApiController@checklicence')->name('checklicence');

			Route::any('listversions','LicensesApiController@listversions')->name('listversions');
			Route::any('currentversion','LicensesApiController@currentversion')->name('currentversion');
		});
	});
});

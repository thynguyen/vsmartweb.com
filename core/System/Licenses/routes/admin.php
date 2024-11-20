<?php
$namespace = 'Vsw\Licenses\Controllers';
Route::group(['module'=>'Licenses', 'namespace' => $namespace,'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','theme:admintheme','CoreMW\checkAdminLogin','CoreMW\CheckAdmin:Licenses'],'prefix'=>config('app.prefixadmin','admin')], function () {
	Route::group(['prefix'=>'licenses'],function(){
		Route::name('licenses.admin.')->group(function () {
			Route::get('', 'LicensesAdminController@main')->name('main');
			Route::get('license-register/{id?}','LicensesAdminController@licenseregister')->name('licenseregister');
			Route::post('license-register/{id?}','LicensesAdminController@postlicenseregister');
			Route::post('getcodelincense','LicensesAdminController@getcodelincense')->name('getcodelincense');
			Route::post('changestatus','LicensesAdminController@changestatus')->name('changestatus');
			Route::delete('dellicense','LicensesAdminController@dellicense')->name('dellicense');

			Route::get('manageversions','LicensesAdminController@manageversions')->name('manageversions');
			Route::get('addversion','LicensesAdminController@addversion')->name('addversion');
			Route::post('addversion','LicensesAdminController@postaddversion');
		});
	});
});
Breadcrumbs::for('admin_index_licenses', function ($trail) {
    $trail->parent('admin_dashboard');
    $trail->push(trans('Langcore::licenses.LicensingManagement'), route('licenses.admin.main'));
});
Breadcrumbs::for('admin_index_manageversions', function ($trail) {
    $trail->parent('admin_index_licenses');
    $trail->push(trans('Langcore::licenses.ManageVersions'), route('licenses.admin.manageversions'));
});
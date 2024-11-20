<?php

Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','theme:admintheme']], function () {
	Route::prefix(config('app.prefixadmin','admin'))->group(function(){
		$namespace = 'Vsw\Permissions\Controllers';
		Route::group(['namespace' => $namespace, 'middleware' => ['CoreMW\checkAdminLogin','CoreMW\CheckAdmin:Permissions']],function(){
			Route::group(['prefix'=>'permissions'],function(){
				Route::get('', 'PermissionsController@index')->name('listadmin');
				Route::get('addadmin/{id?}', 'PermissionsController@AddAdmin')->name('addadmin');
				Route::post('addadmin/{id?}', 'PermissionsController@PostAddAdmin');
				Route::post('deladmin/{id}','PermissionsController@DelAdmin')->name('deladmin');
				Route::get('getlistmember','PermissionsController@GetListMember')->name('getlistmember');
				Route::get('searchmember','PermissionsController@SearchMember')->name('searchmember');
				Route::get('listpermissions','PermissionsController@Permissions')->name('listpermissions');
				Route::get('infopermissions/{id?}','PermissionsController@InfoPermissions')->name('infopermissions');
				Route::post('infopermissions/{id?}','PermissionsController@PostAddPermissions');
				Route::post('delpermissions/{id}','PermissionsController@DelPermissions')->name('delpermissions');
			});
		});
	});
});
Breadcrumbs::for('admin_index_listadmin', function ($trail) {
    $trail->parent('admin_dashboard');
    $trail->push(trans('Langcore::permissions.Administrators'), route('listadmin'));
});
Breadcrumbs::for('admin_index_addadmin', function ($trail,$pagetitle) {
    $trail->parent('admin_index_listadmin');
    $trail->push($pagetitle, route('addadmin'));
});
Breadcrumbs::for('admin_index_permissions', function ($trail) {
    $trail->parent('admin_dashboard');
    $trail->push(trans('Langcore::permissions.Roles'), route('listpermissions'));
});
Breadcrumbs::for('admin_index_infopermissions', function ($trail,$pagetitle) {
    $trail->parent('admin_index_permissions');
    $trail->push($pagetitle, route('infopermissions'));
});
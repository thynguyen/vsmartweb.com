<?php
Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','theme:admintheme']], function () {
	Route::prefix(config('app.prefixadmin','admin'))->group(function(){
		$namespace = 'Core\Controllers';
		Route::group(['module'=>'Admin', 'namespace' => $namespace], function() {
			Route::get('login','AdminController@getLogin')->name('adminlogin');
			Route::post('login','AdminController@postLogin');
			Route::get('logout','AdminController@getLogout')->name('logout');
			Route::group(['middleware' => ['CoreMW\checkAdminLogin']],function(){
				Route::get('', 'AdminController@redirect')->name('adminindex');
				Route::get('dashboard', 'DashboardController@index')->name('dashboard');			
				Route::get('filemanager', 'AdminController@filemanager')->name('filemanager');
				Route::get('check_slug', 'AdminController@check_slug')->name('check_slug');
				
				Route::post('changenewweight/{table}/{id}/{newweight?}','AdminController@Changenewweight')->name('changenewweight');
				Route::post('changeparentweight/{table}/{id}/{parentid}/{newweight?}','AdminController@ChangeParentWeight')->name('changeparentweight');
			});
		});
	});
});

Breadcrumbs::for('admin_dashboard', function ($trail) {
    $trail->push(trans('Langcore::global.dashboard'), route('dashboard'));
});

Breadcrumbs::for('admin_filemanager', function ($trail) {
    $trail->parent('admin_dashboard');
    $trail->push(trans('Langcore::global.filemanager'), route('filemanager'));
});
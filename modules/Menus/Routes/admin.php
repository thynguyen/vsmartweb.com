<?php
Route::prefix('menus')->group(function(){
	Route::name('menus.admin.')->group(function () {
		Route::get('', 'AdminMenusController@main')->name('main');
		Route::get('addgroup/{id?}','AdminMenusController@addgroup')->name('addgroup');
		Route::post('addgroup/{id?}','AdminMenusController@postaddgroup');
		Route::delete('delgroup', 'AdminMenusController@delgroup')->name('delgroup');

		Route::get('listmenus/{groupid}','AdminMenusController@listmenus')->name('listmenus');
		Route::get('addmenu/{groupid}/{id?}','AdminMenusController@addmenu')->name('addmenu');
		Route::post('postaddmenu','AdminMenusController@postaddmenu')->name('postaddmenu');
		Route::post('changeweightdrop','AdminMenusController@changeweightdrop')->name('changeweightdrop');
		Route::delete('delmenu', 'AdminMenusController@delmenu')->name('delmenu');

		Route::post('getlistmenumod','AdminMenusController@getlistmenumod')->name('getlistmenumod');
	});
});
Breadcrumbs::for('admin_menus_main', function ($trail) {
    $trail->parent('admin_dashboard');
    $trail->push(AdminFunc::ReturnModule('Menus','title'), route('menus.admin.main'));
});
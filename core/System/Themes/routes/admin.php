<?php
Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','theme:admintheme']], function () {
	Route::prefix(config('app.prefixadmin','admin'))->group(function(){
		$namespace = 'Vsw\Themes\Controllers';
		Route::group(['namespace' => $namespace, 'middleware' => ['CoreMW\checkAdminLogin','CoreMW\CheckAdmin:Themes']],function(){
			Route::group(['prefix'=>'themes'],function(){
				Route::get('', 'ThemesController@index')->name('AdminThemes');
				Route::get('widget', 'ThemesController@Widget')->name('Widget');
				Route::get('addwidget/{id?}/{placewidget?}/{mod?}/{widgetfile?}', 'ThemesController@AddWidgetSite')->name('AddWidgetSite');
				Route::get('runtoolwidget','ThemesController@StartToolWidget')->name('runtoolwidget');
				Route::get('admintoolbar','ThemesController@AdminToolBar')->name('admintoolbar');
				Route::get('layoutsetup','ThemesController@LayoutSetup')->name('layoutsetup');
				Route::get('selectwidget/{module?}', 'ThemesController@SelectWidget')->name('selectwidget');
				Route::get('showconfigwidget/{position?}/{widgetname?}/{id?}', 'ThemesController@GetJsonWidget')->name('showconfigwidget');

				Route::post('addwidget/{id?}/{placewidget?}/{mod?}/{widgetfile?}', 'ThemesController@PostAddWidget');
				Route::post('active/{theme}', 'ThemesController@ActiveTheme')->name('activetheme');
				Route::post('delete/{theme}', 'ThemesController@DeleteTheme')->name('deletetheme');
				Route::post('upziptheme', 'ThemesController@UpZipTheme')->name('upziptheme');
				Route::post('deletewidget/{id}/{widgetgroup}', 'ThemesController@DeleteWidget')->name('deletewidget');
				Route::post('changelistwidgetaj','ThemesController@ChangeListWidget')->name('changelistwidgetaj');
				Route::post('layoutsetup','ThemesController@PostLayoutSetup');
			});
		});
	});
});
Breadcrumbs::for('admin_index_themes', function ($trail) {
    $trail->parent('admin_dashboard');
    $trail->push(trans('Langcore::themes.MainThemes'), route('AdminThemes'));
});
Breadcrumbs::for('admin_widget_themes', function ($trail) {
    $trail->parent('admin_index_themes');
    $trail->push(trans('Langcore::themes.ManagerWidget'), route('Widget'));
});
Breadcrumbs::for('admin_addwidget_themes', function ($trail) {
    $trail->parent('admin_index_themes');
    $trail->push(trans('Langcore::themes.AddWidget'), route('AddWidgetSite'));
});
Breadcrumbs::for('admin_layoutsetup_themes', function ($trail) {
    $trail->parent('admin_index_themes');
    $trail->push(trans('Langcore::themes.LayoutSetup'), route('layoutsetup'));
});
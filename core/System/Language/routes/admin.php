<?php
Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','theme:admintheme']], function () {
	Route::prefix(config('app.prefixadmin','admin'))->group(function(){
		$namespace = 'Vsw\Language\Controllers';
		Route::group(['namespace' => $namespace, 'middleware' => ['CoreMW\checkAdminLogin','CoreMW\CheckAdmin:Language']],function(){
			Route::group(['prefix'=>'language'],function(){
				Route::get('', 'LanguageController@index')->name('listlang');
				Route::get('addlang/{id?}/{locale?}', 'LanguageController@AddLang')->name('addlang');
				Route::get('translatelang/{locale?}/{group?}','LanguageController@TranslateLang')->name('translatelang');
				Route::get('importlang','LanguageController@ImportLang')->name('importlang');
				Route::get('getlang/{code?}','LanguageController@GetLang')->name('getlang');
				Route::get('addkeylang/{locale}/{group}','LanguageController@AddKeyLang')->name('addkeylang');

				Route::post('addlang/{id?}/{locale?}', 'LanguageController@PostAddLang');
				Route::post('defaultlang/{id}','LanguageController@SetDefaultLang')->name('defaultlang');
				Route::post('changelangweight/{id}/{newweight?}','LanguageController@ChangeLangWeight')->name('changelangweight');
				Route::post('dellang/{id}/{locale}','LanguageController@DelLang')->name('dellang');
				Route::post('activelang/{id}','LanguageController@ActiveLang')->name('activelang');
				Route::post('upziplang', 'LanguageController@UnzipLang')->name('upziplang');
				Route::post('editvaluelang/{group?}', 'LanguageController@EditValueLang')->name('editvaluelang');
				Route::post('exportlang/{locale?}', 'LanguageController@ExportLocaleLang')->name('exportlang');
				Route::post('getdatalang', 'LanguageController@GetDataLang')->name('getdatalang');
				Route::post('addkeylang/{locale}/{group}','LanguageController@PostAddKeyLang');
				Route::post('delkeylang/{group?}/{key}','LanguageController@DelKeyLang')->name('delkeylang');
			});
		});
	});
});

Breadcrumbs::for('admin_index_listlang', function ($trail) {
    $trail->parent('admin_dashboard');
    $trail->push(trans('Langcore::language.Language'), route('listlang'));
});
Breadcrumbs::for('admin_index_addlang', function ($trail) {
    $trail->parent('admin_index_listlang');
    $trail->push(trans('Langcore::language.AddLang'), route('addlang'));
});
Breadcrumbs::for('admin_index_translatelang', function ($trail) {
    $trail->parent('admin_index_listlang');
    $trail->push(trans('Langcore::language.TranslateLang'), route('translatelang'));
});
Breadcrumbs::for('admin_index_importlang', function ($trail) {
    $trail->parent('admin_index_listlang');
    $trail->push(trans('Langcore::language.ImportLanguage'), route('importlang'));
});
Breadcrumbs::for('admin_index_addkeylang', function ($trail) {
    $trail->parent('admin_index_translatelang');
    $trail->push(trans('Langcore::language.ImportLanguage'), route('importlang'));
});
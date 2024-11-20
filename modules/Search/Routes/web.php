<?php

if (AdminFunc::ReturnModule('Search','active')==1) {
	if (CFglobal::cfn('moddefault') == 'Search') {
		Route::get('', 'SearchController@main')->name('indexhome');
	}
	Route::prefix(AdminFunc::GetPrefixMod('Search'))->group(function(){
		Route::name('search.web.')->group(function () {
			Route::get('', 'SearchController@main')->name('main');
			Route::post('','SearchController@search');
			Route::get('tag/{keyword}','SearchController@tag')->name('tag');
		});
	});
	Breadcrumbs::for('module_search_main', function ($trail) {
	    $trail->parent('sitehome');
	    $trail->push(AdminFunc::ReturnModule('Search','title'), route('search.web.main'),['background'=>AdminFunc::ReturnModule('Search','bgmod')]);
	});
}
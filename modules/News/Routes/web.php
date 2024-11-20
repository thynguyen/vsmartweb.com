<?php

if (AdminFunc::ReturnModule('News','active')==1) {
	if (CFglobal::cfn('moddefault') == 'News') {
		Route::get('', 'NewsController@main')->name('indexhome');
	}
	Route::prefix(AdminFunc::GetPrefixMod('News'))->group(function(){
		Route::name('news.web.')->group(function () {
			Route::get('', 'NewsController@main')->name('main');
			Route::get('{slug}.html','NewsController@detail')->name('detail');
			Route::get('cat/{slug}.html','NewsController@cat')->name('cat');
		});
	});
	Breadcrumbs::for('module_news_main', function ($trail) {
	    $trail->parent('sitehome');
	    $trail->push(AdminFunc::ReturnModule('News','title'), route('news.web.main'),['background'=>AdminFunc::ReturnModule('News','bgmod')]);
	});
	Breadcrumbs::for('module_news_detail', function ($trail,$data) {
	    $trail->parent('module_news_main');
	    $trail->push($data->title, route('news.web.detail',['slug'=>$data->slug->slug]),['background'=>AdminFunc::ReturnModule('News','bgmod')]);
	});
	Breadcrumbs::for('module_news_category', function ($trail,$data) {
	    $trail->parent('module_news_main');
	    $trail->push($data->title, route('news.web.cat',['slug'=>$data->slug->slug]),['background'=>AdminFunc::ReturnModule('News','bgmod')]);
	});
}
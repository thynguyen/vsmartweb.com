<?php
Route::prefix('news')->group(function(){
	Route::name('news.admin.')->group(function () {
		//News
		Route::get('', 'AdminNewsController@main')->name('main');
		Route::get('addnew/{id?}','AdminNewsController@addnew')->name('addnew');
		Route::post('addnew/{id?}','AdminNewsController@postaddnew');
		Route::post('checktitleslug','AdminNewsController@checktitleslug')->name('checktitleslug');
		Route::post('activenew','AdminNewsController@activenew')->name('activenew');
		Route::delete('delnew','AdminNewsController@delnew')->name('delnew');
		//Category
		Route::get('category/{id?}', 'AdminNewsController@category')->name('category');
		Route::get('addcategory/{id?}','AdminNewsController@addcategory')->name('addcategory');
		Route::post('addcategory/{id?}','AdminNewsController@postaddcategory');
		Route::delete('delcategory','AdminNewsController@delcategory')->name('delcategory');
		Route::post('changeweightcat','AdminNewsController@changeweightcat')->name('changeweightcat');
		//Congig
		Route::get('config','AdminNewsController@config')->name('config');
		Route::post('config','AdminNewsController@postconfig');
	});
});
Breadcrumbs::for('admin_news_main', function ($trail) {
    $trail->parent('admin_dashboard');
    $trail->push(AdminFunc::ReturnModule('News','title'), route('news.admin.main'));
});
Breadcrumbs::for('admin_news_addnew', function ($trail,$data) {
	if($data){
		$title = $data->title;
	} else {
		$title = transmod('News::AddNew');
	}
    $trail->parent('admin_news_main');
    $trail->push($title, route('news.admin.addnew',['id'=>($data)?$data->id:'null']));
});
Breadcrumbs::for('admin_news_category', function ($trail) {
    $trail->parent('admin_news_main');
    $trail->push(transmod('News::CatalogNews'), route('news.admin.category'));
});
Breadcrumbs::for('admin_news_config', function ($trail) {
    $trail->parent('admin_news_main');
    $trail->push(trans('Langcore::config.ConfigModule'), route('news.admin.config'));
});
<?php
Route::prefix('pages')->group(function(){
	Route::name('pages.admin.')->group(function () {
		Route::get('', 'AdminPagesController@main')->name('main');
		Route::get('choose-interface/{id}/{category?}','AdminPagesController@chooseinterface')->name('chooseinterface');
		Route::post('choose-interface/{id}/','AdminPagesController@postchooseinterface');
		Route::get('pagebuilder/{id}', 'AdminPagesController@pagebuilder')->name('pagebuilder');
		Route::get('editor/{id}', 'AdminPagesController@editor')->name('editor');
		Route::get('addpage/{id?}','AdminPagesController@addpage')->name('addpage');
		Route::get('editcontent/{id}','AdminPagesController@editcontent')->name('editcontent');
		Route::post('addpage/{id?}','AdminPagesController@postaddpage');
		Route::post('addcontent/{id}','AdminPagesController@addcontent')->name('addcontent');

		Route::get('checktitleslug','AdminPagesController@checktitleslug')->name('checktitleslug');
		Route::post('activepage','AdminPagesController@activepage')->name('activepage');
		Route::post('delpage', 'AdminPagesController@delpage')->name('delpage');
		Route::post('uploadfile','AdminPagesController@uploadfile')->name('uploadfile');
		//Group
		Route::get('groups','AdminPagesController@groups')->name('groups');
		Route::get('addgroup/{id?}','AdminPagesController@addgroup')->name('addgroup');
		Route::post('addgroup/{id?}','AdminPagesController@postaddgroup');
		Route::delete('delgroup','AdminPagesController@delgroup')->name('delgroup');
	});
});
Breadcrumbs::for('admin_pages_main', function ($trail) {
    $trail->parent('admin_dashboard');
    $trail->push(AdminFunc::ReturnModule('Pages','title'), route('pages.admin.main'));
});
Breadcrumbs::for('admin_pages_editor', function ($trail,$data) {
    $trail->parent('admin_pages_main');
    $trail->push($data->title, route('pages.admin.editor',$data->id));
});
Breadcrumbs::for('admin_pages_groups', function ($trail) {
    $trail->parent('admin_pages_main');
    $trail->push(transmod('Pages::PageGroups'), route('pages.admin.groups'));
});
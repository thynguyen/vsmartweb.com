<?php
Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','theme:admintheme']], function () {
	Route::prefix(config('app.prefixadmin','admin'))->group(function(){
		$namespace = 'Vsw\Comment\Controllers';
		Route::group(['namespace' => $namespace, 'middleware' => ['CoreMW\checkAdminLogin','CoreMW\CheckAdmin:ManagerComment']],function(){
			Route::group(['prefix'=>'managercomments'],function(){
				Route::get('', 'AdminCommentController@index')->name('comment.adminindex');
				Route::get('edit/{id?}', 'AdminCommentController@edit');
				Route::post('edit/{id?}', 'AdminCommentController@postedit')->name('comment.adminedit');
				Route::post('active/{id}','AdminCommentController@active')->name('comment.adminactive');
				Route::post('del/{id}','AdminCommentController@delete')->name('comment.admindel');
			});
		});
	});
});
Breadcrumbs::for('admin_index_indexcomment', function ($trail) {
    $trail->parent('admin_dashboard');
    $trail->push(trans('Langcore::managercomment.ManagerCommnet'), route('comment.adminindex'));
});
Breadcrumbs::for('admin_index_editcomment', function ($trail) {
    $trail->parent('admin_index_indexcomment');
    $trail->push(trans('Langcore::managercomment.ManagerCommnet'), route('comment.adminedit'));
});
<?php

if (AdminFunc::ReturnModule('Members','active')==1) {
	if (CFglobal::cfn('moddefault') == 'Members') {
		Route::get('', 'MembersController@main')->name('indexhome');
	}
	Route::prefix('members')->group(function(){
		Route::name('members.web.')->group(function () {
			Route::get('', 'MembersController@main')->name('main');
			Route::post('','MembersController@postlogin');
			Route::get('authredirect/{provider}', 'MembersController@authredirect')->name('authredirect');
			Route::get('authcallback/{provider}', 'MembersController@authcallback');
			Route::get('register', 'MembersController@register')->name('register');
			Route::post('register','MembersController@postregister');
			Route::group(['middleware' => ['CoreMW\checkUserLogin','verified']],function(){
				Route::get('userpanel', 'MembersController@userpanel')->name('userpanel');
				Route::get('edit', 'MembersController@edit')->name('edit');
				Route::post('edit', 'MembersController@postedit');
			});
		});
	});
	Breadcrumbs::for('module_members_main', function ($trail) {
	    $trail->parent('sitehome');
	    $trail->push(trans('Langcore::global.Login'), route('members.web.main'),['background'=>AdminFunc::ReturnModule('Members','bgmod')]);
	});
	Breadcrumbs::for('module_members_userpanel', function ($trail) {
	    $trail->parent('sitehome');
	    $trail->push(transmod('members::ProfileMember'), route('members.web.userpanel'),['background'=>AdminFunc::ReturnModule('Members','bgmod')]);
	});
	Breadcrumbs::for('module_members_edit', function ($trail,$data) {
	    $trail->parent('sitehome');
	    $trail->push(transmod('members::EditUser',['user'=>$data->username]), route('members.web.edit'),['background'=>AdminFunc::ReturnModule('Members','bgmod')]);
	});
	Breadcrumbs::for('module_members_register', function ($trail) {
	    $trail->parent('sitehome');
	    $trail->push(transmod('members::RegisterMember'), route('members.web.register'),['background'=>AdminFunc::ReturnModule('Members','bgmod')]);
	});
}
<?php
Route::prefix('members')->group(function(){
	Route::name('members.admin.')->group(function () {
		Route::get('', 'AdminMembersController@main')->name('main');
		Route::post('activemem','AdminMembersController@activemem')->name('activemem');
		Route::get('edituser/{id}', 'AdminMembersController@edituser')->name('edituser');
		Route::post('edituser/{id}', 'AdminMembersController@postedituser');
		Route::post('deluser', 'AdminMembersController@deluser')->name('deluser');
		Route::get('register', 'AdminMembersController@register')->name('register');
		Route::post('register', 'AdminMembersController@postregister');
	});
});
Breadcrumbs::for('admin_members_main', function ($trail) {
    $trail->parent('admin_dashboard');
    $trail->push(AdminFunc::ReturnModule('Members','title'), route('members.admin.main'));
});
Breadcrumbs::for('admin_members_edituser', function ($trail,$data) {
    $trail->parent('admin_members_main');
    $trail->push(transmod('members::EditUser',['user'=>$data->username]), route('members.admin.edituser',$data->id));
});
Breadcrumbs::for('admin_members_register', function ($trail) {
    $trail->parent('admin_members_main');
    $trail->push(transmod('members::RegisterMember'), route('members.admin.register'));
});
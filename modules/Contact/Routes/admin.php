<?php
Route::prefix('contact')->group(function(){
	Route::name('contact.admin.')->group(function () {
		Route::get('', 'AdminContactController@main')->name('main');
		Route::get('parts','AdminContactController@parts')->name('parts');
		Route::get('addpart/{id?}','AdminContactController@addpart')->name('addpart');
		Route::post('addpart/{id?}','AdminContactController@postaddpart');
		Route::post('delpart','AdminContactController@delpart')->name('delpart');
		Route::get('listuser/{arrayuser?}','AdminContactController@listuser')->name('listuser');
		Route::post('delrecipient','AdminContactController@delrecipient')->name('delrecipient');
		Route::get('viewcontact/{id}','AdminContactController@viewcontact')->name('viewcontact');
		Route::post('delcontact','AdminContactController@delcontact')->name('delcontact');
		Route::post('sendreply/{id}','AdminContactController@sendreply')->name('sendreply');
	});
});
Breadcrumbs::for('admin_contact_main', function ($trail) {
    $trail->parent('admin_dashboard');
    $trail->push(AdminFunc::ReturnModule('Contact','title'), route('contact.admin.main'));
});
Breadcrumbs::for('admin_contact_parts', function ($trail) {
    $trail->parent('admin_contact_main');
    $trail->push(transmod('Contact::Parts'), route('contact.admin.parts'));
});
Breadcrumbs::for('admin_contact_viewcontact', function ($trail,$data) {
    $trail->parent('admin_contact_main');
    $trail->push($data->title, route('contact.admin.viewcontact',$data->id));
});
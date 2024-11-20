<?php

if (AdminFunc::ReturnModule('Contact','active')==1) {
	if (CFglobal::cfn('moddefault') == 'Contact') {
		Route::get('', 'ContactController@main')->name('indexhome');
	}
	Route::prefix(AdminFunc::GetPrefixMod('Contact'))->group(function(){
		Route::name('contact.web.')->group(function () {
			Route::get('', 'ContactController@main')->name('main');
			Route::post('submitcontact','ContactController@submitcontact')->name('submitcontact');
			Route::get('sendsuccess','ContactController@sendsuccess')->name('sendsuccess');
			Route::get('getformcontact','ContactController@getformcontact')->name('getformcontact');
		});
	});
	Breadcrumbs::for('module_contact_main', function ($trail) {
	    $trail->parent('sitehome');
	    $trail->push(AdminFunc::ReturnModule('Contact','title'), route('contact.web.main'),['background'=>AdminFunc::ReturnModule('Contact','bgmod')]);
	});
}
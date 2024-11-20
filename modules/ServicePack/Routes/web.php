<?php

if (AdminFunc::ReturnModule('ServicePack','active')==1) {
	if (CFglobal::cfn('moddefault') == 'ServicePack') {
		Route::get('', 'ServicePackController@main')->name('indexhome');
	}
	Route::prefix(AdminFunc::GetPrefixMod('ServicePack'))->group(function(){
		Route::name('servicepack.web.')->group(function () {
			Route::get('', 'ServicePackController@main')->name('main');
			Route::get('register-service/{packcode?}','ServicePackController@registerservice')->name('registerservice');
			Route::post('register-service/{packcode?}','ServicePackController@postregisterservice');
			Route::post('getservicepack','ServicePackController@getservicepack')->name('getservicepack');
			Route::get('checkpay/{userid}/{tradid}/{code}/{expired}','ServicePackController@checkpay')->name('checkpay');
		});
	});
	Breadcrumbs::for('module_servicepack_main', function ($trail) {
	    $trail->parent('sitehome');
	    $trail->push(AdminFunc::ReturnModule('ServicePack','title'), route('servicepack.web.main'),['background'=>AdminFunc::ReturnModule('ServicePack','bgmod')]);
	});
	Breadcrumbs::for('module_servicepack_applyplan', function ($trail) {
	    $trail->parent('module_servicepack_main');
	    $trail->push(transmod('ServicePack::RegisterService'), route('servicepack.web.registerservice'),['background'=>AdminFunc::ReturnModule('ServicePack','bgmod')]);
	});
}
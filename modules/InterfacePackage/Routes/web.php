<?php

if (AdminFunc::ReturnModule('InterfacePackage','active')==1) {
	if (CFglobal::cfn('moddefault') == 'InterfacePackage') {
		Route::get('', 'InterfacePackageController@main')->name('indexhome');
	}
	Route::prefix(AdminFunc::GetPrefixMod('InterfacePackage'))->group(function(){
		Route::name('interfacepackage.web.')->group(function () {
			Route::get('', 'InterfacePackageController@main')->name('main');
			Route::get('{slug}.html','InterfacePackageController@detail')->name('detail');
			Route::post('sentiment','InterfacePackageController@sentiment')->name('sentiment');
			Route::get('category/{slug}','InterfacePackageController@viewcat')->name('viewcat');

			Route::get('getitemtempcat/{id}/{slug}','InterfacePackageController@getitemtempcat')->name('getitemtempcat');
		});
	});
	Breadcrumbs::for('module_interfacepackage_main', function ($trail) {
	    $trail->parent('sitehome');
	    $trail->push(AdminFunc::ReturnModule('InterfacePackage','title'), route('interfacepackage.web.main'),['background'=>AdminFunc::ReturnModule('InterfacePackage','bgmod')]);
	});
	Breadcrumbs::for('module_interfacepackage_detail', function ($trail,$data) {
	    $trail->parent('module_interfacepackage_main');
	    $trail->push($data->title, route('interfacepackage.web.detail',['slug'=>$data->slug]),['background'=>AdminFunc::ReturnModule('InterfacePackage','bgmod')]);
	});
	Breadcrumbs::for('module_interfacepackage_viewcat', function ($trail,$data) {
	    $trail->parent('module_interfacepackage_main');
	    $trail->push($data->title, route('interfacepackage.web.viewcat',['slug'=>$data->slug]),['background'=>AdminFunc::ReturnModule('InterfacePackage','bgmod')]);
	});
}
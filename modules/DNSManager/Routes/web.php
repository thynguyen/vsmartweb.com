<?php

if (AdminFunc::ReturnModule('DNSManager','active')==1) {
	if (CFglobal::cfn('moddefault') == 'DNSManager') {
		Route::get('', 'DNSManagerController@main')->name('indexhome');
	}
	Route::prefix(AdminFunc::GetPrefixMod('DNSManager'))->group(function(){
		Route::name('dnsmanager.web.')->group(function () {
			Route::get('', 'DNSManagerController@main')->name('main');
		});
	});
	Breadcrumbs::for('module_dnsmanager_main', function ($trail) {
	    $trail->parent('sitehome');
	    $trail->push(AdminFunc::ReturnModule('DNSManager','title'), route('dnsmanager.web.main'),['background'=>AdminFunc::ReturnModule('DNSManager','bgmod')]);
	});
}
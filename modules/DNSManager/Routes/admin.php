<?php
Route::prefix('dnsmanager')->group(function(){
	Route::name('dnsmanager.admin.')->group(function () {
		Route::get('', 'AdminDNSManagerController@main')->name('main');
		Route::get('getlistzones','AdminDNSManagerController@getlistzones')->name('getlistzones');
		Route::delete('deletezone/{identifier}','AdminDNSManagerController@deletezone')->name('deletezone');
		Route::get('managerdomain/{zoneid}','AdminDNSManagerController@managerdomain')->name('managerdomain');
		Route::get('getlistrecord','AdminDNSManagerController@getlistrecord')->name('getlistrecord');
		Route::post('createrecord/{id?}','AdminDNSManagerController@createrecord')->name('createrecord');
		Route::delete('delrecord/{zoneid}/{id}','AdminDNSManagerController@delrecord')->name('delrecord');
		Route::post('createzone','AdminDNSManagerController@createzone')->name('createzone');

		Route::get('config','ConfigDNSManagerController@config')->name('config');
		Route::post('config','ConfigDNSManagerController@postconfig');
		Route::get('envcfmod','ConfigDNSManagerController@envcfmod')->name('envcfmod');
	});
});
Breadcrumbs::for('admin_dnsmanager_main', function ($trail) {
    $trail->parent('admin_dashboard');
    $trail->push(AdminFunc::ReturnModule('DNSManager','title'), route('dnsmanager.admin.main'));
});
Breadcrumbs::for('admin_dnsmanager_managerdomain', function ($trail,$data) {
    $trail->parent('admin_dnsmanager_main');
    $trail->push($data['name'], route('dnsmanager.admin.managerdomain',['zoneid'=>$data['id']]));
});
Breadcrumbs::for('admin_dnsmanager_config', function ($trail) {
    $trail->parent('admin_dnsmanager_main');
    $trail->push(trans('Langcore::config.ConfigModule'), route('dnsmanager.admin.config'));
});
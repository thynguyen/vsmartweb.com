<?php
Route::prefix('servicepack')->group(function(){
	Route::name('servicepack.admin.')->group(function () {
		Route::get('', 'AdminServicePackController@main')->name('main');
		Route::get('addservicepack/{id?}', 'AdminServicePackController@addservicepack')->name('addservicepack');
		Route::post('addservicepack/{id?}', 'AdminServicePackController@postaddservicepack');
		Route::post('changeweight','AdminServicePackController@changeweight')->name('changeweight');
		Route::post('activeprice','AdminServicePackController@activeprice')->name('activeprice');
		Route::delete('delpricelist','AdminServicePackController@delpricelist')->name('delpricelist');

		Route::get('transaction-management','AdminServicePackController@transactionmanagement')->name('transactionmanagement');
		Route::get('infouser/{id}','AdminServicePackController@infouser')->name('infouser');
		Route::get('viewtrans/{id}','AdminServicePackController@viewtrans')->name('viewtrans');
		Route::post('viewtrans/{id}','AdminServicePackController@postviewtrans');

		Route::post('listmodulelimit','AdminServicePackController@listmodulelimit')->name('listmodulelimit');
	});
});
Breadcrumbs::for('admin_servicepack_main', function ($trail) {
    $trail->parent('admin_dashboard');
    $trail->push(AdminFunc::ReturnModule('ServicePack','title'), route('servicepack.admin.main'));
});
Breadcrumbs::for('admin_servicepack_transactionmanagement', function ($trail) {
    $trail->parent('admin_servicepack_main');
    $trail->push(transmod('ServicePack::TransactionManagement'), route('servicepack.admin.transactionmanagement'));
});
Breadcrumbs::for('admin_servicepack_viewtrans', function ($trail,$data) {
    $trail->parent('admin_servicepack_transactionmanagement');
    $trail->push($data->trans_code, route('servicepack.admin.viewtrans',['id'=>$data->id]));
});
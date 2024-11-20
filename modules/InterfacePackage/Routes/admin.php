<?php
Route::prefix('interfacepackage')->group(function(){
	Route::name('interfacepackage.admin.')->group(function () {
		Route::get('', 'AdminInterfacePackageController@main')->name('main');
		Route::get('listinterfaces', 'AdminInterfacePackageController@listinterfaces')->name('listinterfaces');

		Route::get('addinterface/{id?}','AdminInterfacePackageController@addinterface')->name('addinterface');
		Route::post('addinterface/{id?}','AdminInterfacePackageController@postaddinterface');
		Route::get('getinterface/{id}','AdminInterfacePackageController@getinterface')->name('getinterface');
		Route::delete('delinterface/{id}','AdminInterfacePackageController@delinterface')->name('delinterface');
		Route::get('searchinterface','AdminInterfacePackageController@searchinterface')->name('searchinterface');
		Route::post('changeactive','AdminInterfacePackageController@changeactive')->name('changeactive');
		Route::get('listservicepack','AdminInterfacePackageController@listservicepack')->name('listservicepack');

		Route::get('category/{id?}','AdminInterfacePackageController@category')->name('category');
		Route::post('addcategory/{id?}','AdminInterfacePackageController@addcategory')->name('addcategory');
		Route::get('listcategory/{id?}','AdminInterfacePackageController@listcategory')->name('listcategory');
		Route::get('listcatall/{id?}','AdminInterfacePackageController@listcatall')->name('listcatall');
		Route::delete('delcategory/{id}','AdminInterfacePackageController@delcategory')->name('delcategory');
		Route::put('updatecategory/{id}','AdminInterfacePackageController@updatecategory')->name('updatecategory');
		Route::get('getstoreicons','AdminInterfacePackageController@getstoreicons')->name('getstoreicons');//Congig
		Route::get('config','AdminInterfacePackageController@config')->name('config');
		Route::post('config','AdminInterfacePackageController@postconfig');
	});
});
Breadcrumbs::for('admin_interfacepackage_main', function ($trail) {
    $trail->parent('admin_dashboard');
    $trail->push(AdminFunc::ReturnModule('InterfacePackage','title'), route('interfacepackage.admin.main'));
});
Breadcrumbs::for('admin_interfacepackage_addinterface', function ($trail,$interface) {
    $trail->parent('admin_interfacepackage_main');
    $trail->push(($interface)?$interface->title:transmod('InterfacePackage::AddInterface'), route('interfacepackage.admin.addinterface',['id'=>$interface['id']]));
});
Breadcrumbs::for('admin_interfacepackage_category', function ($trail,$category) {
	if (!empty($category->catparent)) {
        $trail->parent('admin_interfacepackage_category', $category->catparent);
    } else {
    	$trail->parent('admin_interfacepackage_main');
    }
    $trail->push(($category)?$category->title:transmod('InterfacePackage::Category'), route('interfacepackage.admin.category',['id'=>$category['id']]));
});
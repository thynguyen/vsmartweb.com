<?php
Route::prefix('sliders')->group(function(){
	Route::name('sliders.admin.')->group(function () {
		Route::get('', 'AdminSlidersController@main')->name('main');
		Route::get('addgroup/{id?}', 'AdminSlidersController@addgroup')->name('addgroup');
		Route::post('addgroup/{id?}', 'AdminSlidersController@postaddgroup');
		Route::post('delgroup','AdminSlidersController@delgroup')->name('delgroup');

		Route::get('listsliders/{groupid}','AdminSlidersController@listsliders')->name('listsliders');
		Route::get('addslider/{groupid}/{id?}','AdminSlidersController@addslider')->name('addslider');
		Route::post('submitaddslider','AdminSlidersController@submitaddslider')->name('submitaddslider');
		Route::post('changeweight','AdminSlidersController@changesliderweight')->name('changeweight');
		Route::post('delslider','AdminSlidersController@delslider')->name('delslider');
	});
});
Breadcrumbs::for('admin_sliders_main', function ($trail) {
    $trail->parent('admin_dashboard');
    $trail->push(AdminFunc::ReturnModule('Sliders','title'), route('sliders.admin.main'));
});
Breadcrumbs::for('admin_sliders_listsliders', function ($trail,$data) {
    $trail->parent('admin_sliders_main');
    $trail->push($data->title, route('sliders.admin.listsliders',$data->id));
});
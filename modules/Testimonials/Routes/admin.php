<?php
Route::prefix('testimonials')->group(function(){
	Route::name('testimonials.admin.')->group(function () {
		Route::get('', 'AdminTestimonialsController@main')->name('main');
		Route::get('addtestimonial/{id?}','AdminTestimonialsController@addtestimonial')->name('addtestimonial');
		Route::post('addtestimonial/{id?}','AdminTestimonialsController@postaddtestimonial');
		Route::post('activetestimonial','AdminTestimonialsController@activetestimonial')->name('activetestimonial');
		Route::delete('deltestimonial','AdminTestimonialsController@deltestimonial')->name('deltestimonial');
	});
});
Breadcrumbs::for('admin_testimonials_main', function ($trail) {
    $trail->parent('admin_dashboard');
    $trail->push(AdminFunc::ReturnModule('Testimonials','title'), route('testimonials.admin.main'));
});
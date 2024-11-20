<?php

if (AdminFunc::ReturnModule('Testimonials','active')==1) {
	if (CFglobal::cfn('moddefault') == 'Testimonials') {
		Route::get('', 'TestimonialsController@main')->name('indexhome');
	}
	Route::prefix(AdminFunc::GetPrefixMod('Testimonials'))->group(function(){
		Route::name('testimonials.web.')->group(function () {
			Route::get('', 'TestimonialsController@main')->name('main');
			Route::post('addtestimonial','TestimonialsController@addtestimonial')->name('addtestimonial');
		});
	});
	Breadcrumbs::for('module_testimonials_main', function ($trail) {
	    $trail->parent('sitehome');
	    $trail->push(AdminFunc::ReturnModule('Testimonials','title'), route('testimonials.web.main'),['background'=>AdminFunc::ReturnModule('Testimonials','bgmod')]);
	});
}
<?php
if (AdminFunc::ReturnModule('EmailMarketing','active')==1) {
	Route::prefix(AdminFunc::GetPrefixMod('EmailMarketing'))->group(function(){
		Route::name('emailmarketing.web.')->group(function () {
			Route::post('subscribe', 'EmailMarketingController@subscribe')->name('subscribe');
		});
	});
}
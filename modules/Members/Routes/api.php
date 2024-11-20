<?php

use Illuminate\Http\Request;
Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','theme:theme','CoreMW\RunWidget','CoreMW\CheckWebMod:Members','CoreMW\CloseSite']], function () {
	Route::prefix(AdminFunc::GetPrefixMod('Members'))->group(function(){
		Route::name('password.')->group(function () {
			Route::get('password/reset', 'ResetPasswordController@showLinkRequestForm')->name('request');
			Route::post('password/email', 'ResetPasswordController@sendResetLinkEmail')->name('email');
			Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('reset');
			Route::post('password/reset', 'ResetPasswordController@reset')->name('update');
		});
		Route::name('verification.')->group(function () {
			Route::get('email/verify', 'VerifyAuthController@showvefify')->name('notice');
			Route::get('email/verify/{id}', 'VerifyAuthController@verifymember')->name('verify');
			Route::get('email/resend', 'VerifyAuthController@resend')->name('resend');
		});
	});
});
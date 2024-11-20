<?php
use Modules\EmailMarketing\Http\Middleware\ConnectAPI;

Route::prefix('emailmarketing')->group(function(){
	Route::name('emailmarketing.admin.')->group(function () {
		Route::group(['middleware' =>[ConnectAPI::class]], function () {
			Route::get('', 'AdminEmailMarketingController@main')->name('main');
			Route::post('subscribe','AdminEmailMarketingController@subscribe')->name('subscribe');
			Route::post('deleteemail','AdminEmailMarketingController@deleteemail')->name('deleteemail');
			
			Route::get('campaign', 'AdminEmailMarketingController@campaign')->name('campaign');
			Route::get('addcampaign','AdminEmailMarketingController@addcampaign')->name('addcampaign');
			Route::post('addcampaign','AdminEmailMarketingController@postaddcampaign');

			Route::get('editcampaign/{id}','AdminEmailMarketingController@editcampaign')->name('editcampaign');
			Route::post('editcampaign/{id}','AdminEmailMarketingController@posteditcampaign');
			Route::post('sentcampaign','AdminEmailMarketingController@sentcampaign')->name('sentcampaign');
			Route::delete('delcampaign','AdminEmailMarketingController@delcampaign')->name('delcampaign');
			Route::get('viewreport/{id}','AdminEmailMarketingController@viewreport')->name('viewreport');
			//Doamin
			Route::get('verified-domains','AdminEmailMarketingController@verifieddomains')->name('verifieddomains');
			Route::get('add-domain','AdminEmailMarketingController@adddomain')->name('adddomain');
			Route::post('add-domain','AdminEmailMarketingController@postadddomain');
			Route::get('entercode/{domain}','AdminEmailMarketingController@entercode')->name('entercode');
			Route::post('entercode/{domain}','AdminEmailMarketingController@postentercode');
			Route::delete('deletedomain','AdminEmailMarketingController@deletedomain')->name('deletedomain');
		});
		//Congig
		Route::get('config','ConfigModuleController@config')->name('config');
		Route::post('config','ConfigModuleController@postconfig');
	});
});
Breadcrumbs::for('admin_emailmarketing_main', function ($trail) {
    $trail->parent('admin_dashboard');
    $trail->push(AdminFunc::ReturnModule('EmailMarketing','title'), route('emailmarketing.admin.main'));
});
Breadcrumbs::for('admin_emailmarketing_config', function ($trail) {
    $trail->parent('admin_emailmarketing_main');
    $trail->push(trans('Langcore::config.ConfigModule'), route('emailmarketing.admin.config'));
});
Breadcrumbs::for('admin_emailmarketing_campaign', function ($trail) {
    $trail->parent('admin_emailmarketing_main');
    $trail->push(transmod('EmailMarketing::Campaign'), route('emailmarketing.admin.campaign'));
});
Breadcrumbs::for('admin_emailmarketing_addcampaign', function ($trail) {
    $trail->parent('admin_emailmarketing_campaign');
    $trail->push(transmod('EmailMarketing::AddCampaign'), route('emailmarketing.admin.addcampaign'));
});
Breadcrumbs::for('admin_emailmarketing_verifieddomains', function ($trail) {
    $trail->parent('admin_emailmarketing_campaign');
    $trail->push(transmod('EmailMarketing::VerifiedDomains'), route('emailmarketing.admin.verifieddomains'));
});
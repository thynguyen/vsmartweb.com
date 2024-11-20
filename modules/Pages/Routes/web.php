<?php
use Core\Models\Slugs;
if (AdminFunc::ReturnModule('Pages','active')==1) {
	$slugpage = Slugs::where('module','Pages')->where('locale',app()->getLocale())->pluck('slug')->all();
	if (in_array(CFglobal::cfn('moddefault'), $slugpage)) {
		Route::get('', 'PagesController@pages')->name('indexhome');
	}
	Route::prefix('pages')->group(function(){
		Route::name('pages.web.')->group(function () {
    		Route::get('builderhtml/{title}','PagesController@builderhtml')->name('builderhtml');
    		Route::get('group/{slug?}.html','PagesController@group')->name('group');
		});
	});
	Route::name('pages.web.')->group(function () {
		Route::get('/{slug?}.html', 'PagesController@page')->where('slug', '.*')->name('page');
	});
		
	Breadcrumbs::for('module_pages_page', function ($trail,$data) {
	    $trail->parent('sitehome');
	    $trail->push($data->title, route('pages.web.page',['slug'=>$data->slug->slug]),['background'=>Modules\Pages\FunctPages::GetBGPage($data->id)]);
	});
	Breadcrumbs::for('module_pages_builderhtml', function ($trail,$title) {
	    $trail->parent('sitehome');
	    $trail->push($title, '#');
	});
	Breadcrumbs::for('module_pages_group', function ($trail,$data) {
	    $trail->parent('sitehome');
	    $trail->push($data->title, route('pages.web.group',['slug'=>$data->slug->slug]),['background'=>AdminFunc::ReturnModule('Pages','bgmod')]);
	});
}
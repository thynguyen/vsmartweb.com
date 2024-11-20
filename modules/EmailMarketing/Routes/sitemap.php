<?php
use Core\Models\Slugs;
if (AdminFunc::ReturnModule('EmailMarketing','active')==1) {
	$alllang = LanguageFunc::GetAllLocale();
	$sitemapmod = [];
	if ($alllang) {
		foreach ($alllang as $lang) {
			Route::get('sitemap-emailmarketing-{'.$lang.'}.xml', function($lang)
			{
			    $sitemap_emailmarketing = App::make("sitemap");
			    $datamods = DB::table('vsw_'.$lang.'_emailmarketing')->where('active',1)->orderBy('created_at', 'desc')->get();

			    foreach ($datamods as $data)
			    {
			    	$http = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')?"https://":"http://";
			    	$slug = DB::table('vsw_slugs')->where('item_id',$data->id)->where('module','EmailMarketing')->where('locale',$lang)->pluck('slug')->first();
					$data->link = $http.$_SERVER['HTTP_HOST'].'/'.AdminFunc::GetPrefixMod('EmailMarketing').'/'.$slug.'.html';
					$linkimg = $link.$_SERVER['HTTP_HOST'].$data->image;
					$images[] = [
							'url' => $linkimg,
							'title' => $data->title,
							'caption' => $data->title
						];
			        $sitemap_emailmarketing->add($data->link, $data->updated_at, '0.8', 'daily',$images);
			    }

			    return $sitemap_emailmarketing->render('xml');
			})->name('sitemap-emailmarketing-'.$lang);
			$sitemapmod[] = 'sitemap-emailmarketing-'.$lang.'.xml';
		}
	}
}
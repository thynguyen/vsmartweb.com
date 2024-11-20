<?php
use Modules\News\Entities\News;
if (AdminFunc::ReturnModule('News','active')==1) {
	$alllang = LanguageFunc::GetAllLocale();
	$sitemapmod = [];
	if ($alllang) {
		foreach ($alllang as $lang) {
			Route::get('sitemap-news-'.$lang.'.xml', function() use ($lang)
			{
			    $sitemap_news = App::make("sitemap");
			    $datamods = News::with(['slug'])->where('active',1)->orderBy('created_at', 'desc')->get();

			    foreach ($datamods as $data)
			    {
			    	$http = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')?"https://":"http://";
			    	$slug = $data->slug->slug;
					$data->link = $http.$_SERVER['HTTP_HOST'].'/'.AdminFunc::GetPrefixMod('News').'/'.$slug.'.html';
					$linkimg = $link.$_SERVER['HTTP_HOST'].$data->image;
					$images[] = [
							'url' => $linkimg,
							'title' => $data->title,
							'caption' => $data->title
						];
			        $sitemap_news->add($data->link, $data->updated_at, '0.8', 'daily',$images);
			    }

			    return $sitemap_news->render('xml');
			})->name('sitemap-news-'.$lang);
			$sitemapmod[] = 'sitemap-news-'.$lang.'.xml';
		}
	}
}
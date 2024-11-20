<?php
use Core\Models\Slugs;
use Illuminate\Support\Facades\Schema;
if (AdminFunc::ReturnModule('Pages','active')==1) {
	$alllang = LanguageFunc::GetAllLocale();
	$sitemapmod = [];
	if ($alllang) {
		foreach ($alllang as $lang) {
			Route::get('sitemap-pages-'.$lang.'.xml', function() use ($lang)
			{
			    $sitemap_pages = App::make("sitemap");
                if (Schema::hasTable('vsw_'.$lang.'_pages')) {
                	$datamods = DB::table('vsw_'.$lang.'_pages')->where('active',1)->orderBy('created_at', 'desc')->get();
                	foreach ($datamods as $data)
				    {
				    	$http = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')?"https://":"http://";
	                    $slug = Slugs::where('item_id',$data->id)->where('module','Pages')->where('locale',$lang)->pluck('slug')->first();
						$data->link = route('pages.web.page',['slug'=>$slug]);
						$linkimg = $http.$_SERVER['HTTP_HOST'].$data->image;
						$images[] = [
								'url' => $linkimg,
								'title' => $data->title,
								'caption' => $data->title
							];
				        $sitemap_pages->add($data->link, $data->updated_at, '0.8', 'daily',$images);
				    }

				    return $sitemap_pages->render('xml');
                } else {
				    return $sitemap_pages->render('xml');
                }
                
			    
			})->name('sitemap-pages-'.$lang);
			$sitemapmod[] = 'sitemap-pages-'.$lang.'.xml';
		}
	}
}
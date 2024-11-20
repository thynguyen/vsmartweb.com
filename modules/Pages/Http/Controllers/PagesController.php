<?php

namespace Modules\Pages\Http\Controllers;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Pages\Entities\Pages;
use Modules\Pages\Entities\PageContent;
use Modules\Pages\Entities\PageGroups;
use Modules\Pages\FunctPages;
use Core\Models\Slugs;
use App\User;
use ThemesFunc,SEO;

class PagesController extends Controller
{
    public function builderhtml($title){
        $data = ['title'=>$title];
        return FileViewTheme('Pages','builderhtml',$data);
    }
	public function page($slug='null'){
		$slug = ($slug=='null')?CFglobal::cfn('moddefault'):$slug;
		$datapage = Pages::with(['slug','content'])->where('active',1)->whereHas('slug',function($query) use($slug){
			$query->where('slug',$slug)->where('module','Pages')->where('locale',app() -> getLocale());
		});
		$page = $datapage->first();
		if ($page) {
			$page->increment('views', 1);
			$auth = User::where('id',$page['user_id'])->pluck('username')->first();
			$getlayout = 'pages::web.cover.'. $page['layout'];
			$data = [
				'auth' => $auth,
				'getlayout' => $getlayout,
				'canonical'=>1,
				'page' => $page
			];
			ThemesFunc::SEOMeta($page,'article');
			if ($page->pagetype == 1) {
				return FileViewTheme('Pages','page',$data);
			} else {
				if ($page->content) {
					$content = str_replace('<head>', '<head>'.SEO::generate(), json_decode($page->content->content));
					return $content;
				} else {
					return abort(404);
				}
			}
		} else {
			return abort(404);
		}
	}
	public function group($slug){
		$group = PageGroups::with(['slug'])->whereHas('slug',function($query) use($slug){
			$query->where('slug',$slug)->where('module','PageGroup')->where('locale',LaravelLocalization::getCurrentLocale());
		})->first();
		$data = ['group'=>$group];
		return FileViewTheme('Pages','group',$data);
	}
}

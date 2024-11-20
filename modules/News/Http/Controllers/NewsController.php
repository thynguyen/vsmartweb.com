<?php

namespace Modules\News\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\News\Entities\News;
use Modules\News\Entities\CatalogNews;
use CFglobal,ThemesFunc,AdminFunc;

class NewsController extends Controller
{
    public function main(){
        $seometa = [
            'title'=>AdminFunc::ReturnModule('News', 'title'),
            'description'=>AdminFunc::ReturnModule('News', 'description'),
            'keyword'=>AdminFunc::ReturnModule('News', 'keywords'),
            'image'=>AdminFunc::ReturnModule('News', 'bgmod'),
            'created_at'=>AdminFunc::ReturnModule('News', 'created_at'),
            'updated_at'=>AdminFunc::ReturnModule('News', 'updated_at'),
            'canonical'=>1
        ];
        ThemesFunc::SEOMeta($seometa,'article');
        $data = [];
        if (CFglobal::cfn('displaynews','News') == 'viewall') {
            return FileViewTheme('News','main',$data);
        } else {
            return $this->viewcatnews();
        }
    }
    public function viewcatnews(){
        $data = [];
        return FileViewTheme('News','viewcatnews',$data);
    }
    public function detail($slug){
        $new = News::with(['user','comments','slug'])->whereHas('slug',function($query) use($slug){
            $query->where('slug',$slug);
        })->where('active',1)->first();
        if ($new) {
            $new->increment('views', 1);
            $new->content = content_img_mxw(htmlspecialchars_decode($new->content));
            $new->keywords = ($new->keyword)?explode(',', $new->keyword):[];
            $new->canonical=1;

            $keywords = $new->keywords;
            $new->othernews = News::with(['slug'])->where('id','!=',$new->id);
            $new->othernews = $new->othernews->where(function($query)use($keywords){
                foreach ($keywords as $key => $keyword) {
                    if ($key == 0) {
                        $query->where('keyword','LIKE','%'.$keyword.'%');
                    } else {
                        $query->orwhere('keyword','LIKE','%'.$keyword.'%');
                    }
                }
            });
            $new->othernews = $new->othernews->inRandomOrder()->limit(4)->get();

            $data = ['new'=>$new];      
            ThemesFunc::SEOMeta($new,'article');
            return FileViewTheme('News','detail',$data);
        } else {
            return abort(404);
        }
    }
    public function cat($slug){
        $category = CatalogNews::with(['slug','catpost','subcat'])->whereHas('slug',function($query) use($slug){
            $query->where('slug',$slug);
        })->first();
        ThemesFunc::SEOMeta($category,'article');
        $data = [
            'category'=>$category
        ];
        return FileViewTheme('News','catnews',$data);
    }
}

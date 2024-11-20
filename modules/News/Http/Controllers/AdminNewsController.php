<?php

namespace Modules\News\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\News\Entities\News;
use Modules\News\Entities\CatPost;
use Modules\News\Entities\CatalogNews;
use Modules\News\FunctNews;
use Core\Models\Slugs;
use Vsw\Config\Models\Config;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Validator,AdminFunc,Response,File,ThemesFunc,Storage,Auth;
use SEO\Seo;

class AdminNewsController extends Controller {
	public function main(){
		$allnews = News::orderBy('id', 'asc')->get();
		$data = [];
		return FileViewTheme('News','main',$data,'admin');
	}
	public function category($id='null'){
		$data = [
			'id'=>$id
		];
		return FileViewTheme('News','category',$data,'admin');
	}
	public function addcategory($id='null'){
		$category = CatalogNews::with(['slug'])->where('id',$id)->first();
		$allcatalog = FunctNews::ViewListCat('select','parentid',$category['parentid']);
		$data = [
			'category'=>$category,
			'allcatalog'=>$allcatalog
		];
		return FileViewTheme('News','addcategory',$data,'admin');
	}
	public function postaddcategory(Request $request,$id='null'){
		$rules = [ 
            'title' => 'required|string',
        ];
        $messages = [
            'title.required' => trans('Langcore::global.error_title'),
        ];
        $Validator = Validator::make($request -> all(), $rules, $messages);
        if ($Validator -> fails()) {
            return redirect() -> back() -> withErrors($Validator) -> withInput();
        } else {
        	$catalogtitle = CatalogNews::where('title',$request->title)->first();
        	$catalogid = CatalogNews::with(['slug'])->where('id',$id)->first();
        	if ($catalogtitle && $id == 'null' or $catalogtitle && $catalogid['title'] !=$request->title ) {
        		return redirect()->back()->with('warning', trans('validation.unique',['attribute'=>trans('Langcore::global.Title')]))->withInput();
        	} else {
	        	$dataslug = Slugs::where('slug',$request->slug)->where('module','CategoryNews')->where('locale',app()->getLocale())->first();
	        	if ($dataslug  && $id == 'null' or $dataslug && $catalogid->slug->slug !=$request->slug) {
	        		return redirect()->back()->with('warning', trans('validation.unique',['attribute'=>'Slug']))->withInput();
	        	} else {
		        	$catalog = ($id=='null')?new CatalogNews:CatalogNews::find($id);
		        	$catalog->parentid = ($request->parentid)?$request->parentid:0;
		        	$catalog->title = $request->title;
		        	$catalog->description = $request->description;
		        	$catalog->keyword = ($request->keyword)?$request->keyword:AdminFunc::extractKeyWords($request->title);

			        $maxlev = CatalogNews::where('id', $request->parentid)->first();
		        	if ($catalog->parentid == 0 ) {
		        		$catalog->lev = 0;
		        	}  else {
		        		$catalog->lev = $maxlev['lev']+1;
		        	}
					if ($id == 'null' or $request->parentold != $request->parentid) {        	       	
			        	$weight = CatalogNews::where('parentid', $request->parentid)->max('weight');
			        	$maxWeight = intval($weight) + 1; 
			        	$catalog->weight = $maxWeight;
			        }
		        	$catalog->save();
	        		if ($id == 'null') {
		        		AdminFunc::PostSlug($request->slug,$catalog->id,'CategoryNews');
		        	} elseif ($request->slug != $catalogid->slug->slug) {
		        		AdminFunc::PostSlug($request->slug,$catalog->id,'CategoryNews',$catalogid->slug->id);
		        	}
		        	return back()->with('success', trans('Langcore::global.SaveSuccess'));
	        	}
	        }
        }
	}
	public function delcategory(Request $request){
		$id = $request->id;
		$catid = CatalogNews::where('id',$id)->first();
		$parentid = CatalogNews::where('parentid',$id)->first();
		if (is_null($parentid)) {
			if ($catid->delete()) {
				AdminFunc::DelSlug($id,'CategoryNews');
				$catalogs = CatalogNews::where('parentid', $catid['parentid'])->orderBy('id', 'asc')->get();
				$weight = 0;
				foreach ($catalogs as $key => $value) {
					++$weight;
					$update_weight = CatalogNews::find($value['id']);
					$update_weight->weight = $weight;
					$update_weight->save();
				}
				return Response::json(trans('Langcore::global.DelSuccess'), 200);
			}
			return Response::json(trans('Langcore::global.CannotBeDeleted'), 404);
		}
		return Response::json(transmod('News::CannotDelCat'), 404);
	}

	public function changeweightcat(Request $request){
		$id = $request->id;
		$parentid = $request->parentid;
		$newweight = $request->newweight;
		$idrow = CatalogNews::where('id',$id)->where('parentid',$parentid)->first();
		if ($idrow) {
			$rows = CatalogNews::where('id','!=',$id)->where('parentid',$parentid)->orderBy('weight', 'asc')->pluck('id');
			$weight = 0;
			foreach ($rows as $rowid) {
				$weight++;
				if ($weight == $newweight) {
					$weight++;
				}
				CatalogNews::where('id',$rowid)->update(['weight'=>$weight]);
			}
			CatalogNews::where('id',$id)->update(['weight'=>$newweight]);
			return Response::json(trans('Langcore::language.SuccessChangeWeight'), 200);
		}
		return Response::json(trans('Langcore::language.ErrorChangeWeight'), 400);
	}

	public function addnew($id='null'){
		$new = News::with(['slug','catpost'])->where('id',$id)->first();
		if ($id!='null') {
			$title = $new->title;
		} else {
			$title = transmod('News::AddNew');
		}
		$catpost = ($id!='null')?collect($new->catpost)->pluck('catid'):'';
		$allcatalog = FunctNews::ViewListCat('checkbox','catid',$catpost);
		$data = [
			'new'=>$new,
			'title'=>$title,
			'allcatalog'=>$allcatalog,
		];
		return FileViewTheme('News','addnew',$data,'admin');
	}
	public function postaddnew(Request $request,$id='null'){
		$rules = [ 
            'title' => 'required|string',
            'content' => 'required|string',
            'slug' => 'required|string'
        ];
        $messages = [
            'title.required' => trans('Langcore::global.error_title'),
        ];
        $Validator = Validator::make($request -> all(), $rules, $messages);
        if ($Validator -> fails()) {
            return redirect() -> back() -> withErrors($Validator) -> withInput();
        } else {
        	$newid = News::find($id);
        	$user = Auth::user();

        	$new = ($id=='null')?new News:$newid;
        	$new->title = $request->title;
        	$new->content = htmlspecialchars($request->content);//htmlspecialchars_decode($request->content)
        	$new->description = $request->description;
        	$new->keyword = ($request->keyword)?$request->keyword:AdminFunc::extractKeyWords($request->content);
        	$new->active = ($request->active)?1:0;
        	$new->user_id = $user->id;
        	$new->image = str_replace(url('/'), '', $request->image);
        	$new->numcat = ($request->catid)?count($request->catid):0;
        	$new->save();
        	if ($id == 'null') {
        		AdminFunc::PostSlug($request->slug,$new->id,'News');
        	} elseif ($request->slug != $newid->slug->slug) {
        		AdminFunc::PostSlug($request->slug,$new->id,'News',$newid->slug->id);
        	}
        	AdminFunc::SaveSEO($new, route('news.web.detail', $request->slug), [
				'title' => $request->title,
				'images' => [
					str_replace(url('/'), '', $request->image)
				],
				'page' => [
					'title'=>$request->title,
					'description'=>string_limit_words($request->description,152,'...'),
					'content'=>$request->content,
					'focus_keyword'=>$request->focus_keyword
				]
			]);
        	CatPost::where('newid',$new->id)->delete();
        	if ($request->catid) {
	        	foreach ($request->catid as $value) {
	        		$catpost = new CatPost;
	        		$catpost->catid = $value;
	        		$catpost->newid = $new->id;
	        		$catpost->save();
	        	}
        	}
        	return redirect()->route('news.admin.main') -> with('success', trans('Langcore::global.SaveSuccess'));
        }
	}

    public function checktitleslug(Request $request){
        $pagetitle = News::where('title',$request->title)->first();
        $newslug = Slugs::where('slug',$request->slug)->where('module','News')->where('locale',LaravelLocalization::getCurrentLocale())->first();
        $checktitle = ($pagetitle)?'1':'0';
        $mestitle = ($pagetitle)?'<span class="text-danger"><i class="fad fa-exclamation-triangle fa-lg"></i> '.trans('Langcore::global.TitleAlreadyExists').'</span>':'<span class="text-success"><i class="fad fa-thumbs-up fa-lg"></i> '.trans('Langcore::global.CanUseTitle').'</span>';
        $checkslug = ($newslug)?'1':'0';
        $messlug = ($newslug)?'<span class="text-danger"><i class="fad fa-exclamation-triangle fa-lg"></i> '.trans('Langcore::global.SlugAlreadyExists').'</span>':'<span class="text-success"><i class="fad fa-thumbs-up fa-lg"></i> '.trans('Langcore::global.CanUseSlug').'</span>';
        $data = [
            'title' => [
                'check'=>$checktitle,
                'msg'=> $mestitle
            ],
            'slug' => [
                'check'=>$checkslug,
                'msg'=> $messlug
            ]
        ];
        return $data;
    }
    public function activenew(Request $request) {
    	$id = $request->id;
		$datanew = News::where('id', $id);
		$idnew = $datanew->first();
		if ($idnew) {
			$act = ($idnew['active'] == 1) ? 0 : 1;
			$datanew->update(['active' => $act]);
			$messenger = ($idnew['active'] == 1) ? trans('Langcore::global.CancelActive') : trans('Langcore::global.SuccessfulActive');
			return Response::json($messenger, 200);
		}
		return Response::json('Error', 404);
	}
	public function delnew(Request $request){
		$id = $request->id;
		$newid = News::where('id',$id)->first();
		if ($newid) {
			if ($newid->delete()) {
				AdminFunc::DelSlug($id,'News');
				CatPost::where('newid',$id)->delete();
				return Response::json(trans('Langcore::global.DelSuccess'), 200);
			}
		}
		return Response::json(trans('Langcore::global.CannotBeDeleted'), 404);
	}
	public function config(){
		$configview =['viewall'=>transmod('News::ViewAllNews'),'viewlistcat'=>transmod('News::ViewListCat')];
		$data = ['configview'=>$configview];
		return FileViewTheme('News','config',$data,'admin');
	}
	public function PostConfig(Request $request){
        $rules = [];
        $messages = [];
        $Validator = Validator::make($request -> all(), $rules, $messages);
        if ($Validator -> fails()) {
            return redirect() -> back() -> withErrors($Validator) -> withInput();
        } else {
        	$configarray = array();
            $configarray['displaynews'] = $request->displaynews;
            $configarray['perpage_new'] = $request->perpage_new;
            $configarray['perpagecat_new'] = $request->perpagecat_new;
            foreach ($configarray as $config_name => $config_value) {
                $finddb = Config::where('config_name',$config_name)->where('lang',Auth::user()->locale);
                if(empty($finddb->first())){
                    $config = new Config;
                    $config->lang = Auth::user()->locale;
                    $config->module = 'News';
                    $config->config_name = $config_name;
                    $config->config_value = $config_value;
                    $config->save();
                } else {                
                    $config = $finddb->update(['config_value'=>$config_value]);
                }
            }
            return back() -> with('success', lang('content.success_config'));
        }
	}
}
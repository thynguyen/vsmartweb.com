<?php

namespace Modules\Pages\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\Pages\Entities\Pages;
use Modules\Pages\Entities\PageContent;
use Modules\Pages\Entities\PageGroups;
use Modules\Pages\FunctPages;
use Core\Models\Slugs;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Validator,AdminFunc,Response,File,ThemesFunc,Storage,Auth;

class AdminPagesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function main()
    {
        session()->forget('datapagestemp');
        // $pages = Pages::orderBy('id', 'asc')->get();
        $data = [
            // 'pages'=>$pages
        ];
        return FileViewTheme('Pages','main',$data,'admin');
    }
    public function addpage($id='null')
    {
        $page = Pages::with(['slug','content'])->where('id',$id)->first();
        if ($id!='null') {
            $page->slug = $page->slug->slug;
        }
        $listlayout = collect(FunctPages::GetCoverLayout())->pluck('covername','covername');
        $pagetype = [
            '1'=>transmod('Pages::Editor'),
            '2'=>transmod('Pages::PageBuilder')
        ];
        $groups = [''=>'--']+PageGroups::pluck('title','id')->all();
        $data = [
            'page'=>$page,
            'listlayout'=>$listlayout,
            'pagetype'=>$pagetype,
            'groups' => $groups,
            'http_host' => url('/')
        ];
        if ($id != 'null' || in_array(Auth::user()->in_group, [1,2]) || Pages::where('userid',Auth::user()->id)->count() < AdminFunc::GetNumRole('Pages')) {
            return FileViewTheme('Pages','addpage',$data,'admin');
        } else {
            return '<div class="modal-body">'.trans('Langcore::global.ServicePackageLimit').'</div>';
        }
    }
    public function postaddpage(Request $request,$id='null'){
        if ($id != 'null' || in_array(Auth::user()->in_group, [1,2]) || Pages::where('userid',Auth::user()->id)->count() < AdminFunc::GetNumRole('Pages')) {
            $rules = [ 
                'title' => 'required|string'
            ];
            $messages = [
                'title.required' => trans('Langcore::global.error_title')
            ];
            $Validator = Validator::make($request -> all(), $rules, $messages);
            if ($Validator -> fails()) {
                return redirect() -> back() -> withErrors($Validator) -> withInput();
            } else {
                if ($request->pagetype == 1) {
                    $layout = ($request->layout)?$request->layout:'body';
                } else {
                    $layout = null;
                }
                
                $pageid = Pages::find($id);
                $page = ($id=='null')?new Pages:$pageid;
                $page->groupid = $request->groupid;
                $page->title = $request->title;
                $page->description = $request->description;
                $page->keyword = ($request->keyword)?$request->keyword:AdminFunc::extractKeyWords($request->content);
                $page->pagetype = $request->pagetype;
                $page->image = str_replace(url('/'), '', $request->image);
                $page->layout = $layout;
                $page->active = ($request->active)?1:0;
                $page->userid = Auth::user()->id;
                $page->save();
                if ($id == 'null') {
                    AdminFunc::PostSlug($request->slug,$page->id,'Pages');
                } elseif ($request->slug != $pageid->slug->slug) {
                    AdminFunc::PostSlug($request->slug,$page->id,'Pages',$pageid->slug->id);
                }
                if ($id == 'null') {
                    if ($request->pagetype == 1) {
                        return redirect()->route('pages.admin.editor',$page->id) -> with('success', trans('Langcore::global.SaveSuccess'));
                    } elseif ($request->pagetype == 2) {
                        // return redirect()->route('pages.admin.pagebuilder',$page->id) -> with('success', trans('Langcore::global.SaveSuccess'));
                        return redirect()->route('pages.admin.chooseinterface',$page->id) -> with('success', trans('Langcore::global.SaveSuccess'));
                    }
                } else {
                    return redirect()->route('pages.admin.main') -> with('success', trans('Langcore::global.SaveSuccess'));
                }
            }
        } else {
            return redirect()->route('pages.admin.main')->with('warning', trans('Langcore::global.ServicePackageLimit'));
        }
    }
    public function checktitleslug(Request $request){
        if ($request->type == 'pages') {
            $datatitle = Pages::where('title',$request->title)->first();
            $dataslug = Slugs::where('slug',$request->slug)->where('module','Pages')->where('locale',LaravelLocalization::getCurrentLocale())->first();
        } elseif($request->type == 'pagegroup') {
            $datatitle = PageGroups::where('title',$request->title)->first();
            $dataslug = Slugs::where('slug',$request->slug)->where('module','PageGroup')->where('locale',LaravelLocalization::getCurrentLocale())->first();
        }
        $checktitle = ($datatitle)?'1':'0';
        $mestitle = ($datatitle)?'<i class="fad fa-exclamation-triangle fa-lg"></i> '.trans('Langcore::global.TitleAlreadyExists'):'<i class="fad fa-thumbs-up fa-lg"></i> '.trans('Langcore::global.CanUseTitle');
        $checkslug = ($dataslug)?'1':'0';
        $messlug = ($dataslug)?'<i class="fad fa-exclamation-triangle fa-lg"></i> '.trans('Langcore::global.SlugAlreadyExists'):'<i class="fad fa-thumbs-up fa-lg"></i> '.trans('Langcore::global.CanUseSlug');
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
    public function editcontent($id){
        $page = Pages::find($id);
        if ($page->pagetype == 1) {
            return redirect()->route('pages.admin.editor',$page->id);
        } elseif ($page->pagetype == 2) {
            return redirect()->route('pages.admin.pagebuilder',$page->id);
        }
    }
    public function pagebuilder($id)
    {
        $page = Pages::with(['slug','content'])->where('id',$id)->first();
        $contentfile = '';
        if ($page->pagetype == 2 && $page->content) {
            if (!File::exists(public_path('sessionfile'))) {
                File::makeDirectory(public_path('sessionfile'), 0755, true);
            }
            if (session('pagecontentfile') && File::exists(public_path('sessionfile/pagebuilder_'.session('pagecontentfile').'_vswv2_0.html'))) {
                File::delete(public_path('sessionfile/pagebuilder_'.session('pagecontentfile').'_vswv2_0.html'));
            }
            session(['pagecontentfile'=>Str::random(50)]);
            $file = 'sessionfile/pagebuilder_'.session('pagecontentfile').'_vswv2_0.html';
            file_put_contents(public_path($file), json_decode($page->content->content));
            $contentfile = asset($file);
        }
        $datatemp = session('datapagestemp');
        $data = [
            'page'=>$page,
            'contentfile'=>$contentfile,
            'datatemp'=>$datatemp
        ];
        if ($page->pagetype == 1) {
            return redirect()->route('pages.admin.editor',$id);
        } else {
            return FileViewTheme('Pages','pagebuilder',$data,'admin');
        }
    }
    public function editor($id)
    {
        $page = Pages::with(['slug','content'])->where('id',$id)->first();
        $data = [
            'page'=>$page
        ];
        if ($page->pagetype == 2) {
            return redirect()->route('pages.admin.pagebuilder',$id);
        } else {
            return FileViewTheme('Pages','editor',$data,'admin');
        }
    }
    public function activepage(Request $request) {
        $id = $request->id;
        $dbpage = Pages::where('id', $id);
        $idpage = $dbpage -> first();
        if ($idpage) {
            $act = ($idpage['active'] == 1) ? 0 : 1;
            $dbpage -> update(['active' => $act]);
            $messenger = ($idpage['active'] == 1) ? trans('Langcore::global.CancelActive') : trans('Langcore::global.SuccessfulActive');
            return Response::json($messenger, 200);
        }
        return Response::json('Error', 404);
    }
    public function delpage(Request $request){
        $id = $request->id;
        $pageid = Pages::where('id',$id)->first();
        if ($pageid) {
            AdminFunc::DelSlug($id,'Pages');
            $pageid->delete();
            return Response::json(trans('Langcore::global.DelSuccess'), 200);
        }
        return Response::json(trans('Langcore::global.CannotBeDeleted'), 404);
    }
    public function addcontent(Request $request,$id){
        $pagecontent = PageContent::with(['page'])->where('pageid',$id)->first();
        $content = ($pagecontent)?$pagecontent:new PageContent;
        $content->pageid = $id;
        $content->content = json_encode($request->html);
        $content->save();
        session()->forget('datapagestemp');
        if ($pagecontent && $pagecontent->page->pagetype == 2) {
            return trans('Langcore::global.SaveSuccess');
        } else {
            return redirect()->route('pages.admin.main') -> with('success', trans('Langcore::global.SaveSuccess'));
        }
    }
    public function uploadfile(Request $request){
        if (!File::exists(public_path('storage/uploads/pagebuilder'))) {
            File::makeDirectory(public_path('storage/uploads/pagebuilder'), 0755, true);
        }
        $folder = '/uploads/pagebuilder';
        $name = Str::random(25);
        $image = ThemesFunc::uploadOne($request->file, $folder, 'public', $name);
        return Storage::url($image);
    }
    public function chooseinterface($id,$category='null'){
        $data =[
            'id'=>$id,
            'category'=>$category
        ];
        return FileViewTheme('Pages','chooseinterface',$data,'admin');
    }
    public function postchooseinterface(Request $request,$id){
        $template = $request->template;
        $temspath = base_path('modules/Pages/Resources/assets/js/builder/templates');
        $basemodule = $temspath . DIRECTORY_SEPARATOR . $template;
        $filepath = $basemodule . '/template.php';
        if (File::exists($filepath)) {
            $status = 'true';
            include($filepath);
            session(['datapagestemp'=>$template]);
        } else {
            $status = 'false';
        }
        $data = ['status'=>$status];
        return $data;
    }
    public function groups(){
        $data = [];
        return FileViewTheme('Pages','groups',$data,'admin');
    }
    public function addgroup($id='null'){
        $group = PageGroups::find($id);
        $data = ['group'=>$group];
        return FileViewTheme('Pages','addgroup',$data,'admin');
    }
    public function postaddgroup(Request $request,$id='null'){
        $rules = [ 
            'title' => 'required|string'
        ];
        $messages = [
            'title.required' => trans('Langcore::global.error_title')
        ];
        $Validator = Validator::make($request -> all(), $rules, $messages);
        if ($Validator -> fails()) {
            return redirect() -> back() -> withErrors($Validator) -> withInput();
        } else {
            $group = ($id=='null')?New PageGroups:PageGroups::find($id);
            $group->title = $request->title;
            $group->description = $request->description;
            $group->keyword = $request->keyword;
            if ($id == 'null') {                   
                $weight = PageGroups::max('weight');
                $maxWeight = intval($weight) + 1; 
                $group->weight = $maxWeight;
            }
            $group->save();

            if ($id == 'null') {
                AdminFunc::PostSlug($request->slug,$group->id,'PageGroup');
            } elseif ($request->slug != $catalogid->slug->slug) {
                AdminFunc::PostSlug($request->slug,$group->id,'PageGroup',$group->slug->id);
            }
            return redirect()->back()->with('success', trans('Langcore::global.SaveSuccess'));
        }
    }
    public function delgroup(Request $request){
        $id = $request->id;
        $pageid = PageGroups::where('id',$id)->first();
        if ($pageid->delete()) {
            AdminFunc::DelSlug($id,'PageGroup');
            return Response::json(trans('Langcore::global.DelSuccess'), 200);
        }
        return Response::json(trans('Langcore::global.CannotBeDeleted'), 404);
    }
}

<?php

namespace Modules\InterfacePackage\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\InterfacePackage\Entities\InterfaceCat;
use Modules\InterfacePackage\Entities\Interfaces;
use Modules\ServicePack\Entities\ServicePack;
use Vsw\Config\Models\Config;
use Validator,AdminFunc,Response,Auth;

class AdminInterfacePackageController extends Controller
{
    public function main(){
        $data = [];
        return FileViewTheme('InterfacePackage','main',$data,'admin');
    }
    public function listinterfaces(){
        $interfaces = Interfaces::with(['cat','servicepack','comments','vote','authsentiment','sentiment','sentimentlike','sentimentdislike'])->orderByDesc('id')->paginate(10);
        return $interfaces;
    }
    public function getinterface($id){
        $interface = Interfaces::find($id);
        return $interface;
    }
    public function addinterface($id='null'){
        $interface = Interfaces::find($id);
        $data = ['interface'=>$interface];
        return FileViewTheme('InterfacePackage','addinterface',$data,'admin');
    }
    public function postaddinterface(Request $request,$id='null'){
        $dbinterface = $request->interface;
        $interface = ($id=='null')?New Interfaces:Interfaces::find($id);
        $interface->title = $dbinterface['title'];
        $interface->slug = $dbinterface['slug'];
        $interface->description = $dbinterface['description'];
        $interface->keyword = json_encode($dbinterface['keyword']);
        $interface->content = $dbinterface['content'];
        $interface->image = str_replace(url('/'), '', $dbinterface['image']);
        $interface->catid = $dbinterface['catid'];
        $interface->svp_code = $dbinterface['svp_code'];
        $interface->active = $dbinterface['active'];
        $interface->save();
        return response('success');
        // return $dbinterface;
    }
    public function delinterface(Request $request,$id){
        $interface = Interfaces::find($id);
        $interface->delete();
        return response([
            'result' => 'success'
        ], 200);
    }

    public function category($id='null'){
        $category = InterfaceCat::with(['catparent'])->where('id',$id)->first();

        $listicon = AdminFunc::GetListIcons('null','iconvalue','icon');
        $data = [
            'category'=>$category,
            'listicon'=>$listicon
        ];
        return FileViewTheme('InterfacePackage','category',$data,'admin');
    }
    public function addcategory(Request $request,$id='null'){
        $dbcategory = $request->category;
        if ($id=='null' || $id!=$dbcategory['parentid']) {
            $category = ($id=='null')?New InterfaceCat:InterfaceCat::find($id);
            $category->parentid = $dbcategory['parentid'];
            $category->icon = $dbcategory['icon'];
            $category->title = $dbcategory['title'];
            $category->slug = $dbcategory['slug'];
            $category->description = $dbcategory['description'];
            $category->keyword = json_encode($dbcategory['keyword']);
            $maxlev = InterfaceCat::where('id', $dbcategory['parentid'])->first();
            if ($category->parentid == 0 ) {
                $category->lev = 0;
            }  else {
                $category->lev = $maxlev['lev']+1;
            }
            // if ($id=='null') {
                $weight = InterfaceCat::where('parentid', $dbcategory['parentid'])->max('weight');
                $maxWeight = intval($weight) + 1; 
                $category->weight = $maxWeight;
            // }
            $category->save();
            // return $category;
            return response([
                'category' => $category
            ], 200);
        } else {
            return response([
                'errors' => ['name'=>'Lỗi rồi']
            ],404);
        }
    }
    public function listcategory($id='null'){
        $categorys = InterfaceCat::where('parentid',$id)->orderByDesc('id')->paginate(10);
        return response($categorys, 200);
    }
    public function listcatall($id='null'){
        $categorys = InterfaceCat::where('id','!=',$id)->orderBy('id')->pluck('id','title')->all();
        return response($categorys, 200);
    }
    public function delcategory(Request $request,$id){
        $category = InterfaceCat::find($id);
        $category->delete();
        return response([
            'result' => 'success'
        ], 200);
    }
    public function updatecategory(Request $request,$id){
        $dbcategory = $request->category;
        $category = InterfaceCat::find($id);
        $category->title = $dbcategory['title'];
        $category->description = $dbcategory['description'];
        $category->save();
        return response([
            'result' => 'success'
        ], 200);
    }
    public function getstoreicons(){
        return AdminFunc::GetListIcons('null','iconvalue','icon');
    }
    public function listservicepack(){
        $servicepack = ServicePack::where('active',1)->pluck('code','title')->all();
        return response($servicepack,200);
    }
    public function searchinterface(Request $request){
        $keyword = $request->keyword;
        $interfaces = Interfaces::with(['cat','servicepack']);
        $interfaces = $interfaces->where(function($query) use ($keyword) {
            $query->where('title', 'LIKE', '%'.$keyword.'%')
                ->orwhere('description', 'LIKE', '%'.$keyword.'%');
        });
        $interfaces = $interfaces->orderByDesc('id')->paginate(10);
        return $interfaces;
    }
    public function changeactive(Request $request){
        $id = $request->id;
        $interface = Interfaces::where('id',$id);
        $act = ($interface->first()->active == 1) ? 0 : 1;
        $interface->update(['active'=>$act]);
        $messenger = ($interface->first()->active == 0) ? trans('Langcore::global.CancelActive').' "'.$interface->first()->title.'"' : trans('Langcore::global.SuccessfulActive').' "'.$interface->first()->title.'"';
        return Response::json($messenger, 200);
    }
    public function config(){
        $configview =['showall'=>transmod('InterfacePackage::ShowAll'),'showbycat'=>transmod('InterfacePackage::ShowByCategory')];
        $data = ['configview'=>$configview];
        return FileViewTheme('InterfacePackage','config',$data,'admin');
    }
    public function PostConfig(Request $request){
        $rules = [];
        $messages = [];
        $Validator = Validator::make($request -> all(), $rules, $messages);
        if ($Validator -> fails()) {
            return redirect() -> back() -> withErrors($Validator) -> withInput();
        } else {
            $configarray = array();
            $configarray['displayinterface'] = $request->displayinterface;
            foreach ($configarray as $config_name => $config_value) {
                $finddb = Config::where('config_name',$config_name)->where('lang',Auth::user()->locale);
                if(empty($finddb->first())){
                    $config = new Config;
                    $config->lang = Auth::user()->locale;
                    $config->module = 'InterfacePackage';
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

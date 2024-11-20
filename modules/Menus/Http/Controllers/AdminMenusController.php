<?php

namespace Modules\Menus\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Redirect,Auth,View,Storage,Theme,CFglobal,ThemesFunc,Validator,Carbon,AdminFunc,Response,File;
use Modules\Menus\Entities\Menus;
use Modules\Menus\Entities\GroupMenus;
use Modules\Menus\FunctMenus;
use Vsw\Modules\Models\Modules;
use Illuminate\Support\Facades\Log;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AdminMenusController extends Controller
{
    public function main(){
		$groupid = (GroupMenus::first())?GroupMenus::first()->id:0;
		$groups = GroupMenus::with(['menu'])->get();
        $data = ['groups'=>$groups,'groupid'=>$groupid];
        return FileViewTheme('Menus','main',$data,'admin');
    }
    public function addgroup($id='null'){
    	$group = GroupMenus::where('id',$id)->first();
    	$data = ['group'=>$group];
        return FileViewTheme('Menus','addgroup',$data,'admin');
    }
	public function postaddgroup(Request $request,$id='null'){
		$rules = [];
        $messages = [
        	'required' => trans('validation.required',['attribute'=>''])
        ];
        $Validator = Validator::make($request -> all(), $rules, $messages);
        if ($Validator -> fails()) {
            return redirect() -> back() -> withErrors($Validator) -> withInput();
        } else {
        	$group = ($id=='null')?New GroupMenus:GroupMenus::find($id);
        	$group->title = $request->title;
        	$group->description = $request->description;
        	$group->save();
        	if ($group) {
        		return redirect()->back() -> with('success', trans('Langcore::global.SaveSuccess'));
        	}
        }
	}
    public function delgroup(Request $request){
        $group = GroupMenus::with(['menu'])->where('id',$request->id)->first();
        if (count($group->menu)==0) {
            if ($group->delete()) {
                $data = [
                    'success'=> 1,
                    'messages'=>trans('Langcore::global.DelSuccess')
                ];
                return $data;
            }
            $data = [
                'success'=> 0,
                'messages'=>trans('Langcore::global.CannotBeDeleted')
            ];
            return $data;
        } else {
            $data = [
                'success'=> 0,
                'messages'=>transmod('menus::CannotBeDeletedBlock')
            ];
            return $data;
        }
    }
	public function listmenus($groupid){
		$group = GroupMenus::with(['menu'=>function($query){
			$query->with(['submenus'])->orderBy('weight');
		}])->where('id',$groupid)->first();
		$menus = FunctMenus::ListMenuDrop($groupid);
		$data = ['group'=>$group,'menus'=>$menus];
        return FileViewTheme('Menus','listmenus',$data,'admin');
	}
	public function addmenu($groupid,$id='null'){
		$menu = Menus::find($id);
		$menus = FunctMenus::ViewListMenu($groupid,$menu['parentid']);

		$list_route = FunctMenus::ViewListRoute($menu['route']);
        $list_module = Modules::where('active',1)->where('locale', LaravelLocalization::getCurrentLocale())->pluck('title','pathmod')->all();
		$list_icons = AdminFunc::GetListIcons($menu['icon'],'iconvalue','icon');
        $list_target = [
            '_self'=>'Self',
            '_blank'=>'Blank',
            '_top'=>'Top'
        ];
		$data = [
			'groupid'=>$groupid,
			'menu'=>$menu,
			'menus'=>$menus,
			'list_route'=>$list_route,
			'list_icons'=>$list_icons,
            'list_target'=>$list_target,
            'list_module'=>$list_module
		];
		return FileViewTheme('Menus','addmenu',$data,'admin');
	}
	public function postaddmenu(Request $request) {
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
        	$id = $request->id;
        	
        	$menus = ($id == 'null' || $id == '')?new Menus:Menus::find($id);
        	$menus->parentid = $request->parentid;
        	$menus->groupid = $request->groupid;
        	$menus->title = $request->title;
        	$menus->urltype = $request->urltype;
        	if($request->urltype == 'url'){
        		$menus->url = $request->url;
        	} else {
        		$menus->url = NULL;
        	}
            $menus->target = $request->target;
        	if($request->urltype == 'route'){ 
                $url = ($request->module != 'index')?str_replace(url('/'), '', $request->route):'/';
                $menus->route = $url;
                $menus->module = $request->module;
        	} else {
        		$menus->route = NULL;
				$menus->module = NULL;
        	}
        	$menus->icon = $request->icon;
        	if ($id == 'null' or $request->parentold != $request->parentid) {        	       	
	        	$weight = Menus::where('groupid', $request->groupid)->where('parentid', $request->parentid)->max('weight');
	        	$maxWeight = intval($weight) + 1; 
	        	$menus->weight = $maxWeight;
	        }
	        $maxlev = Menus::where('id', $request->parentid)->first();
        	if ($menus->parentid == 0 ) {
        		$menus->lev = 0;
        	}  else {
        		$menus->lev = $maxlev['lev']+1;
        	}
        	$menus->active = 1;
        	$menus->save();
        	if($request->parentid > 0) {
				$getparentmenus = Menus::where('groupid', $request->groupid)->where('parentid', $request->parentid)->orderBy('id', 'asc')->get();
				$idparentmenu = [];
				foreach ($getparentmenus as $key => $value) {
					$idparentmenu[] = $value['id'];
				}
	        	$parentmenu = Menus::where('groupid', $request->groupid)->where('id', $request->parentid)->first();
	        	$parentmenu->submenu = collect($idparentmenu)->implode(',');
	        	$parentmenu->save();
	        }
	        if($request->parentold > 0) {
				$getparentmenus_old = Menus::where('groupid', $request->groupid)->where('parentid', $request->parentold)->orderBy('id', 'asc')->get();
				$idparentmenu_old = [];
				foreach ($getparentmenus_old as $key => $value) {
					$idparentmenu_old[] = $value['id'];
				}
	        	$parentmenu_old = Menus::where('groupid', $request->groupid)->where('id', $request->parentold)->first();
	        	$parentmenu_old->submenu = (!empty($idparentmenu_old)) ? collect($idparentmenu_old)->implode(',') : NULL;
	        	$parentmenu_old->save();
	        }
        	if ($id == 'null') {
        		Log::info(transmod('menus::LogAddSuccessMenu',['name'=>Auth::user()->username,'title'=>$request->title]));
        	} else {
        		Log::info(transmod('menus::LogEditSuccessMenu',['name'=>Auth::user()->username,'title'=>$request->title]));
        	}
        	if ($menus) {
        		$msg = trans('Langcore::global.SaveSuccess');
        		$data = ['msg'=>$msg,'data'=>$menus];
        		return $data;
        	}
        }
	}
	public function changeweightdrop(Request $request){
		$parentid = ($request->parentid)?$request->parentid:0;
        $parentidold = ($request->parentidold)?$request->parentidold:0;
        $weight = ($request->weight)?$request->weight:[];
        $id = $request->id;
        $groupid = $request->groupid;
        if ($parentid != $parentidold) {
            $findmenus = Menus::where('active',1)->where('id',$id);
            $findmenus->update(['parentid'=>$parentid]);
            
            if ($parentid > 0) {
                $getparentmenus = Menus::where('groupid',$groupid)->where('parentid', $parentid)->orderBy('id', 'asc')->pluck('id')->all();
                $parentmenu = Menus::where('groupid', $groupid)->where('id', $parentid)->first();
                $parentmenu->submenu = ($getparentmenus) ? implode(',',$getparentmenus) : NULL;
                $parentmenu->save();
            }
            if ($parentidold>0 && $parentidold != $parentid) {
                $getparentmenus_old = Menus::where('parentid', $parentidold)->orderBy('id', 'asc')->pluck('id')->all();
                $parentmenu_old = Menus::where('groupid', $groupid)->where('id', $parentidold)->first();
                $parentmenu_old->submenu = ($getparentmenus_old) ? implode(',',$getparentmenus_old): NULL;
                $parentmenu_old->save();
            }

            $newsweight = Menus::where('active',1)->where('groupid',$groupid)->where('parentid',$parentid)->orderBy('weight', 'asc')->pluck('id');
            if ($newsweight) {
                foreach ($newsweight as $key => $weightnew) {
                    Menus::where('id',$weightnew)->update(['weight'=> $key+1]);
                }
            }
            $oldweight = Menus::where('active',1)->where('groupid',$groupid)->where('parentid',$parentidold)->pluck('id');
            if ($oldweight) {
                foreach ($oldweight as $key => $weightold) {
                    Menus::where('id',$weightold)->update(['weight'=> $key+1]);
                }
            }
            return Response::json(transmod('menus::SuccessfulChange'), 200);
        } else {
            if (count($weight)>0) {
                for ($i=0; $i < count($weight); $i++) {
                    $finddb = Menus::where('active',1)->where('id',$weight[$i])->where('parentid',$parentid); 
                    $finddb->update(['weight'=>$i + 1]);
                }
                return Response::json(transmod('menus::SuccessfulChange'), 200);
            } else {
                return Response::json('ERROR', 400);
            }
        }
	}

    public function delmenu(Request $request) {
        $id = $request->id;
        $menu = Menus::findOrFail($id);
        if (is_null($menu['submenu'])) {
            if($menu->delete()){
                $weight = 0;
                $getparentmenus = Menus::where('groupid', $menu['groupid'])->where('parentid', $menu['parentid'])->orderBy('id', 'asc')->pluck('id')->all();
                foreach ($getparentmenus as $value) {
                    ++$weight;
                    $update_weight = Menus::find($value);
                    $update_weight->weight = $weight;
                    $update_weight->save();
                }
                if(!empty($menu['parentid'])){
                    $parentmenu = Menus::where('groupid', $menu['groupid'])->where('id', $menu['parentid'])->first();
                    $parentmenu->submenu = ($getparentmenus) ? implode(',',$getparentmenus) : NULL; 
                    $parentmenu->save();
                }

                Log::warning(trans('Langcore::menus.LogDelSuccessMenu',['name'=>Auth::user()->username,'title'=>$menu['title']]));
                return 'success';               
            }
            abort(404, trans('Langcore::global.Error404'));
        }
        abort(404, trans('Langcore::global.Error404'));
    }

    public function getlistmenumod(Request $request){
        $module = $request->module;
        $link = $request->link;
        $modulePath = base_path('modules');
        $basemodule = $modulePath . DIRECTORY_SEPARATOR . $module;
        if (File::exists($basemodule.'/Routes/web.php') || $module == 'index') {
            $menus = $mainmenus = [];
            if (\Route::has(strtolower($module).'.web.main')) {
                $mainmenus = [route(strtolower($module).'.web.main')=>transmod('Menus::ModulePageMain',['module'=>$module])];
            }
            if ($module == 'index') {
                $mainmenus = [route('indexhome')=>trans('Langcore::global.home')];
            }
            if (AdminFunc::ReturnModule($module,'active')==1 && File::exists($basemodule . '/getlistmenu.php')) {
                include($basemodule . "/getlistmenu.php");
            }

            $allmenus = array_merge($mainmenus,$menus);
            $data = [
                'menus'=>$allmenus,
                'link'=>$link
            ];
            return FileViewTheme('Menus','getlistmenumod',$data,'admin');
        }
        return false;
    }
}
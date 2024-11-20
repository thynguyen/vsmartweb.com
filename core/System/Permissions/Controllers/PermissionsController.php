<?php
namespace Vsw\Permissions\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Vsw\Permissions\Models\Permissions;
use Vsw\Permissions\Models\Roles;
use Vsw\Modules\Models\Modules;
use Redirect,Auth,View,Storage,Theme,CFglobal,ThemesFunc,ModulesFunc,Validator,Carbon,File,Artisan,Exception,AdminFunc,ZipArchive,Response;
use App\User;
/**
 * 
 */
class PermissionsController extends Controller
{
	public function index(Request $request){
		// $listadmin = User::where('in_group','!=',0)->paginate(20);
		$listadmin = User::join('vsw_permissions','vsw_users.in_group','=','vsw_permissions.id')->where('in_group','!=',0)->select('*','vsw_users.id as userid')->paginate(20);
		foreach ($listadmin as $admin) {
			if ($admin['in_group'] == 1) {
				$admin['lever']='<span class="text-danger"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>';
			} elseif($admin['in_group'] == 2){
				$admin['lever']='<span class="text-danger"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i></span>';
			} elseif($admin['in_group'] > 2) {
				$admin['lever']='<span class="text-danger"><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i></span>';
			}
			$admins[] = $admin;
		}
		if ($request->ajax()) {
            return view('System.Permissions.ajaxindex',compact('listadmin'));
        }
		return view('System.Permissions.index',compact('listadmin'));
	}

	public function AddAdmin($id='null'){
		if ($id == 1) {
        	return redirect()->back()->with('warning', trans('Langcore::permissions.SuperAdminChangeAlert'));
		} else {
			$locale = ['sys',app()->getLocale()];
			$infoad['listpermis'] = Permissions::pluck('name', 'id');
			$infoad['id'] = $id;
			$infoad['admin'] = User::find($id);
			$infoad['pagetitle']= ($id>0)? trans('Langcore::permissions.EditAdmin',['name'=>$infoad['admin']['username']]): trans('Langcore::permissions.AddAdmin');
			return view('System.Permissions.addadmin',$infoad);
		}
	}
	public function PostAddAdmin(Request $request, $id='null'){
		$rules = [ 
            'adminname' => 'required|string',
        ];
        $messages = [
            'adminname.required' => trans('Langcore::global.error_title')
        ];
        $Validator = Validator::make($request -> all(), $rules, $messages);
        if ($Validator -> fails()) {
            return redirect() -> back() -> withErrors($Validator)-> withInput();
        } else {
        	$memberid = User::where('username',$request->adminname);
        	if ($memberid->first()) {
        		if ($memberid->first()->id == 1) {
        			return redirect()->back()->with('warning', trans('Langcore::permissions.SuperAdminChangeAlert'));
        		} else {
        			if ($request->permis) {
        				$memberid->update(['in_group'=>$request->permis]);
        			} else {
        				return redirect()->back()->with('warning', trans('Langcore::permissions.NoRoleUser'));
        			}
	        		if ($request->adminemail) {
	        			$memberid->update(['email'=>$request->adminemail]);
	        		}
		        	$mess = ($id>0) ? trans('Langcore::global.SaveSuccess') : trans('Langcore::global.AddSuccess') ;
		        	return redirect()->route('listadmin')->with('success', $mess);
        		}
        	} else {
        		return redirect()->back()->with('warning', trans('Langcore::permissions.NoUserFound'));
        	}
        }
	}
	public function DelAdmin($id){
		$adminid = User::where('id',$id);
		if ($adminid->first()) {
			if ($adminid->first()->in_group == 1) {
				return Response::json(trans('Langcore::global.CannotBeDeleted'), 404);
			} else {
				$adminid->update(['in_group'=>0]);
				return Response::json(trans('Langcore::global.DelSuccess'), 200);
			}
			return Response::json(trans('Langcore::global.CannotBeDeleted'), 404);
		}
		return Response::json(trans('Langcore::global.CannotBeDeleted'), 404);
	}
	public function GetListMember(Request $request){
		$listmember = User::where('in_group',0)->paginate(20);
		$member['listmember'] = $listmember;
		if ($request->ajax()) {
            return view('System.Permissions.ajaxlistmember',compact('listmember'));
        }
		return view('System.Permissions.getlistmember',compact('listmember'));
	}

	public function SearchMember(Request $request){
		$userinfo = $request->userinfo;
		if ($request -> ajax()) {
			$findmember = ($userinfo)?User::where('in_group',0)
			->where(function ($query) use ($userinfo){
				$query->where('username','LIKE','%'.$userinfo.'%')
				->orwhere('mobile','LIKE','%'.$userinfo.'%')
				->orwhere('email','LIKE','%'.$userinfo.'%');
			})->get() : User::where('in_group',0)->get();
			if(count($findmember)>0){
				foreach ($findmember as $key => $member) {
					$output[] ='<tr>'.
					'<td>'.$member->id.'</td>'.
					'<td>'.$member->username.'</td>'.
					'<td>'.$member->email.'</td>'.
					"<td><button class=\"btn btn-sm btn-primary\" type=\"button\" onclick=\"addidmember('".$member->username."')\"><i class=\"fas fa-plus-square\"></i></button></td>".
					'</tr>';
				}
			} else {
				$output = '<tr><td colspan="3" class="text-center">'.trans('Langcore::permissions.NoResults').'</td></tr>';
			}
			$data = ['datamem'=>$output,'memcount'=>count($findmember)];
			return Response($data);
		}
	}

	public function Permissions(){
		$permission['list'] = Permissions::all();
		return view('System.Permissions.permissions',$permission);
	}
	public function InfoPermissions($id='null'){
		if ($id==1 or $id==2) {
			return redirect()->route('listpermissions')->with('warning', trans('Langcore::permissions.NoAccessAllowed'));
		} else {
			$mods = [];
			if (!empty($id)) {
				$permis['data'] = Permissions::find($id);
			}
			$permis['id'] = $id;
			$permis['pagetitle']= ($id>0)? trans('Langcore::permissions.EditRole',['name'=>$permis['data']['name']]): trans('Langcore::permissions.AddRole');
			$modules = ModulesFunc::getAllmodule();
			foreach ($modules as $mod) {
				$mod['id'] = AdminFunc::ReturnModule($mod['pathmod'],'id');
				$mod['active'] = AdminFunc::ReturnModule($mod['pathmod'],'active');
				$mod['title'] = (AdminFunc::ReturnModule($mod['pathmod'],'title'))?AdminFunc::ReturnModule($mod['pathmod'],'title'):$mod['pathmod'];
				$mod['rule'] = Roles::where('modules',$mod['pathmod'])->where('per_id',$id)->first();
				$mods[] = $mod;
			}
			$permis['modules'] = $mods;
			return view('System.Permissions.infopermissions',$permis);
		}
	}
	public function PostAddPermissions(Request $request,$id='null'){
		$rules = [ 
            'name' => 'required|string',
        ];
        $messages = [
            'name.required' => trans('Langcore::global.error_title')
        ];
        $Validator = Validator::make($request -> all(), $rules, $messages);
        if ($Validator -> fails()) {
            return redirect() -> back() -> withErrors($Validator)-> withInput();
        } else {
        	if ($id=='null' && Permissions::where('name',$request->name)->first()) {
        		return redirect()->back()->with('warning', trans('Langcore::permissions.NameAlreadyExists'));
        	} else {
	        	$permisid = Permissions::find($id);
	        	$dbpermis = ($permisid)?$permisid:new Permissions;
	    		if ($id==1) {
	    			$superadmin = 1;
	    		} elseif($id==2) {
	    			$superadmin = 2;
	    		} else {
		        	$superadmin = 0;
		        }
	        	$dbpermis->name = $request->name;
	        	$dbpermis->superadmin = $superadmin;
	        	$dbpermis->save();
				Roles::where('per_id',$id)->delete();
	        	$roles = $request->rolemod;
	        	if ($roles) {
	        		$per_id = ($id>0)?$request->id:Permissions::max('id');
		            foreach ($roles as $id_modul => $data) {
		            	$rolesid = Roles::where('modules',$id_modul)->where('per_id',$id)->first();
		            		$arr_role = ($rolesid)?$rolesid:new Roles;	
		            		$arr_role->id = Roles::max('id')+1;
			            	$arr_role->per_id = $per_id;
			            	$arr_role->modules = $id_modul;
			            	$arr_role->view = @$data['view'] ?: 0;
			            	$arr_role->add = @$data['add'] ?: 0;
			            	$arr_role->delete = @$data['delete'] ?: 0;
			            	$arr_role->save();
		            }
		        }
	        	$mess = ($id>0) ? trans('Langcore::global.SaveSuccess') : trans('Langcore::global.AddSuccess') ;
	        	return redirect()->route('listpermissions')->with('success', $mess);
        	}
        }
	}
	public function DelPermissions($id){
		$permiss = Permissions::whereNotIn('id', [1,2])->where('id',$id)->first();
		if ($permiss) {
			if ($permiss->delete()) {
				Roles::where('per_id',$id)->delete();
				User::where('in_group',$id)->update(['in_group'=>0]);
				$messenger = trans('Langcore::permissions.DelRolesuccess',['name'=>$permiss->name]);
				return Response::json($messenger, 200);
			}
			return Response::json(trans('Langcore::global.CannotBeDeleted'), 404);
		}
		return Response::json(trans('Langcore::global.CannotBeDeleted'), 404);
	}
}
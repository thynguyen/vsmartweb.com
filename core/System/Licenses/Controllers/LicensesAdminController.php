<?php
namespace Vsw\Licenses\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Vsw\Licenses\Models\VSWLicenses;
use Vsw\Licenses\Models\VSWVersions;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Events\Dispatcher;
use Redirect,Auth,View,Storage,Theme,CFglobal,ThemesFunc,ModulesFunc,Validator,Carbon,File,Artisan,Exception,AdminFunc,ZipArchive,Response;
use Vsw\Licenses\LicensesFunc;

class LicensesAdminController extends Controller
{
	public function main(){
		$licenses = VSWLicenses::orderByDesc('id')->get();
		$status = [
			'activated'=>trans('Langcore::licenses.Activated'),
			'suspend'=>trans('Langcore::licenses.Suspend'),
			'delete'=>trans('Langcore::global.Delete')
		];
		$data = ['licenses'=>$licenses,'status'=>$status];
        return FileViewTheme('Licenses','main',$data,'admin');
	}
	public function licenseregister($id = 'null'){
		$license = VSWLicenses::find($id);
		$status = [
			'not activated'=>trans('Langcore::licenses.NotActivated'),
			'activated'=>trans('Langcore::licenses.Activated'),
			'suspend'=>trans('Langcore::licenses.Suspend'),
			'delete'=>trans('Langcore::global.Delete')
		];
		$data = ['status'=>$status,'license'=>$license];
        return FileViewTheme('Licenses','licenseregister',$data,'admin');
	}
	public function postlicenseregister(Request $request,$id = 'null'){
		$rules = [];
        $messages = [
            'required' => trans('validation.required',['attribute'=>''])
        ];
        $Validator = Validator::make($request -> all(), $rules, $messages);
        if ($Validator -> fails()) {
            return redirect() -> back() -> withErrors($Validator) -> withInput();
        } else {
        	$newlicense = ($id == 'null')?New VSWLicenses:VSWLicenses::find($id);
        	$newlicense->license = $request->license;
        	$newlicense->domain = $request->domain;
        	$newlicense->start_day = $request->start_day;
        	$newlicense->expiration_date = $request->expiration_date;
        	$newlicense->status = $request->status;
        	$newlicense->message = $request->message;
        	$newlicense->save();
        	if ($newlicense) {
        		return redirect()->back() -> with('success', trans('Langcore::global.SaveSuccess'));
        	}
        }
	}
	public function getcodelincense(){
		$coupons = LicensesFunc::generate_licenses(1, 16, null, null, 'true', 'true', 'false', 'false', 'XXXX-XXXX-XXXX-XXXX');
		return $coupons;
	}
	public function changestatus(Request $request){
		$license = VSWLicenses::where('id',$request->id);
		if ($license->update(['status'=>$request->status])) {
			return Response::json(trans('Langcore::global.SaveSuccess'), 200);
		}
		return Response::json('ERROR', 404);
	}
	public function dellicense(Request $request){
		$id = $request->id;
		$license = VSWLicenses::where('id',$id)->first();
		if ($license) {
			if ($license->delete()) {
				return Response::json(trans('Langcore::global.DelSuccess'), 200);
			}
		}
		return Response::json(trans('Langcore::global.CannotBeDeleted'), 404);
	}
	public function manageversions(){
		$data = [];
        return FileViewTheme('Licenses','manageversions',$data,'admin');
	}
	public function addversion(){
		$data = [];
        return FileViewTheme('Licenses','addversion',$data,'admin');
	}
	public function postaddversion(Request $request){
		$rules = [];
        $messages = [
            'required' => trans('validation.required',['attribute'=>''])
        ];
        $Validator = Validator::make($request -> all(), $rules, $messages);
        if ($Validator -> fails()) {
            return redirect() -> back() -> withErrors($Validator) -> withInput();
        } else {
        	VSWVersions::where('current',1)->update(['current'=>0]);
        	$version = New VSWVersions;
        	$version->version = $request->vswversion;
        	$version->changelog = json_encode($request->changlog);
        	$version->current = 1;
        	$version->save();
        	if ($version) {
        		return redirect()->back() -> with('success', trans('Langcore::global.SaveSuccess'));
        	}
        }
	}
}
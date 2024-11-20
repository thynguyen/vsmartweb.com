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
use Redirect,Auth,View,Storage,Theme,CFglobal,ThemesFunc,ModulesFunc,Validator,File,Artisan,Exception,AdminFunc,ZipArchive,Response;
use Vsw\Licenses\LicensesFunc;
use Ixudra\Curl\Facades\Curl;
use Carbon\Carbon;

class LicensesApiController extends Controller
{
	public function licence(){
		return 'Not Connect';
	}
	public function checklicence(Request $request){
		$key = $request->key;
		$license = VSWLicenses::where('license',$key)->select('domain','status','expiration_date','message')->first();
        
		if ($license) {
			$expiration_date = Carbon::parse($license->expiration_date, 'UTC');
	        $now = Carbon::now();
	        if($license->status == 'suspend') {
	        	$license->message = trans('Langcore::licenses.SuspendLicense');
	        } elseif (!is_null($license->expiration_date) && $now > $expiration_date) {
	        	$license->message = trans('Langcore::licenses.ErrorExpirationDate',['expiration_date'=>$license->expiration_date]);
	        } else {
	        	$license->message = $license->message;
	        }
			return $license;
		} else {
			return false;
		}
	}
	public function listversions(Request $request){
		//$key = $request->key;
		//$domain = $request->domain;
		//$license = VSWLicenses::where('license',$key)->where('domain',$domain)->first();
		//if ($license) {
			$versions = VSWVersions::orderByDesc('current')->orderByDesc('id')->limit(10)->get();
			return $versions;
		//} else {
		//	return false;
		//}
	}
	public function currentversion(Request $request){
		//$key = $request->key;
		//$domain = $request->domain;
		//$license = VSWLicenses::where('license',$key)->where('domain',$domain)->first();
		//if ($license) {
			$versions = VSWVersions::where('current',1)->first();
			return $versions;
		//} else {
		//	return false;
		//}
	}
}

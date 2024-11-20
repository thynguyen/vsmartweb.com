<?php
namespace Core\Foundation;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use View,File,Theme,CFglobal,AdminFunc;
use Ixudra\Curl\Facades\Curl;
use Carbon\Carbon;

trait CoreSystemManager{
	public function expiration(){
        $info = iflc();
        $expiration_date = Carbon::parse($info->expiration_date, 'UTC');
        $now = Carbon::now();
		if ($now > $expiration_date && !is_null($info->expiration_date)) {
			$data = ['info'=>$info];
			return view(CFglobal::cfn('admintheme').'::layouts.expiration',$data);
		} else {
			return redirect()->route('indexhome');
		}
	}
	public function notlicense(){
        $info = iflc();
		if ($info) {
			return redirect()->route('indexhome');
		} else {
			return view(CFglobal::cfn('admintheme').'::layouts.notlicense');
		}
	}
	public function suspended(){
        $info = iflc();
        if ($info->status == 'suspend') {
        	$data = ['info'=>$info];
			return view(CFglobal::cfn('admintheme').'::layouts.suspended',$data);
        } else {
			return redirect()->route('indexhome');
        }
	}
	public function notdomainlicense(){
        $info = iflc();
		if ($info && $_SERVER['HTTP_HOST'] == $info->domain) {
			return redirect()->route('indexhome');
		} else {
			$data = [];
			return view(CFglobal::cfn('admintheme').'::layouts.notdomainlicense',$data);
		}
	}
	public function closesite(){
		if (env('SITE_CLOSURE_MODE')!=0) {
			$data = [];
			return view(CFglobal::cfn('admintheme').'::layouts.closesite',$data);
		} else {
			return redirect()->route('indexhome');
		}
	}
}
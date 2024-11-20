<?php

namespace Modules\EmailMarketing\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use CFglobal;

class ConfigModuleController extends Controller
{
	public function config(){
		$data = [];
		return FileViewTheme('EmailMarketing','config',$data,'admin');
	}
	public function PostConfig(Request $request){
        $data = $request->all();
        $updateenv = CFglobal::UpdateOrEditENV($data);
        if ($updateenv == true) {
            return back() -> with('success', lang('content.success_config'));
        } else {
            return back() -> with('error', trans('Langcore::global.ErrorUninstall'));
        }
	}
}
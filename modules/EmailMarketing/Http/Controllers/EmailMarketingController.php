<?php

namespace Modules\EmailMarketing\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Newsletter;

class EmailMarketingController extends Controller
{
	public function subscribe(Request $request){
		$email = $request->email;
		$member = Newsletter::hasMember($email);
		if ($member == 1) {
			$mes = '<font class="text-danger">'.transmod('EmailMarketing::EmailExists',['email'=>$email]).'</font>';
		} else {
			Newsletter::subscribe($email);
			$mes = '<font class="text-success">'.transmod('EmailMarketing::SubscribedSuccessfully').'</font>';
		}
		return $mes;
	}
}

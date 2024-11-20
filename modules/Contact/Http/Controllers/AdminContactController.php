<?php

namespace Modules\Contact\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Redirect,Auth,View,Storage,Theme,CFglobal,ThemesFunc,Validator,Carbon,AdminFunc,Response,Image,Mail,Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Modules\Contact\Entities\Contact;
use Modules\Contact\Entities\CustomerContact;
use Modules\Contact\Entities\PartsContact;
use Modules\Contact\Entities\PartsContactEmail;
use Modules\Contact\Entities\ReplyContact;
use Modules\Contact\Mail\SendReply;
use App\User;

class AdminContactController extends Controller {
	public function main(){
		$contacts = Contact::with(['customer','part','reply'])->orderBy('read')->orderByDesc('id')->get();
		$contacts = $contacts->paginate(15);
		$paginator = $contacts->render('contact::admin.paginator');
		$data = [
			'contacts'=>$contacts,
			'paginator'=>$paginator
		];
		return view('contact::admin.main',$data);
	}
	public function parts(){
		$parts = PartsContact::get();
		$data = ['parts'=>$parts];
		return view('contact::admin.parts',$data);
	}
	public function addpart($id='null'){
		$part = PartsContact::with(['partsemail'=>function($query){
			$query->with(['user'=>function($query){
				$query->select('id','email','firstname','lastname');
			}]);
		}])->where('id',$id)->first();
		$data = ['part'=>$part];
		return view('contact::admin.addpart',$data);
	}
	public function postaddpart(Request $request,$id='null'){
		$rules = [];
        $messages = [
        	'required' => trans('validation.required',['attribute'=>''])
        ];
        $Validator = Validator::make($request -> all(), $rules, $messages);
        if ($Validator -> fails()) {
            return redirect() -> back() -> withErrors($Validator) -> withInput();
        } else {
        	$part = ($id=='null')?New PartsContact:PartsContact::find($id);
        	$part->title = $request->title;
        	$part->mobile = $request->mobile;
        	$part->email = $request->email;
        	$part->save();
        	
        	if ($request->recipients) {
	        	foreach ($request->recipients as $key => $recipients) {
	        		$finddb = PartsContactEmail::where('partid',$part->id)->where('userid',$recipients['userid'])->first();
	        		$sendmail = isset($recipients['sendemail'][0])?1:0;
	        		$partemail = (!$finddb)?New PartsContactEmail:$finddb;
	        		$partemail->partid = $part->id;
	        		$partemail->userid = $recipients['userid'];
	        		$partemail->sendemail = $sendmail;
	        		$partemail->save();
	        	}
        	}

        	if ($part) {
        		return redirect()->back() -> with('success', trans('Langcore::global.SaveSuccess'));
        	}
        }
	}
	public function delpart(Request $request){
		$part = PartsContact::where('id',$request->id)->first();
		if ($part->delete()) {
			return Response::json(trans('Langcore::global.DelSuccess'), 200);
		} else {
			return Response::json(trans('Langcore::global.CannotBeDeleted'), 404);
		}
	}
	public function listuser($arrayuser='null'){
		$iduser = explode(",",$arrayuser);
		if ($iduser!='null') {
			$alluser = User::where('id','!=',Auth::user()->id)->whereNotIn('id',$iduser)->where('active',1)->select('id','username','firstname','lastname','email')->get();
		} else {
			$alluser = User::where('id','!=',Auth::user()->id)->where('active',1)->select('id','username','firstname','lastname','email')->get();
		}
		$data = ['alluser'=>$alluser];
		if ($alluser->count()>0) {
			return view('contact::admin.listuser',$data);
		} else {
			return false;
		}
	}
	public function delrecipient(Request $request){
		$partemail = PartsContactEmail::where('partid',$request->partid)->where('userid',$request->userid)->first();
		if ($partemail) {
			if ($partemail->delete()) {
				return Response::json(trans('Langcore::global.DelSuccess'), 200);
			} else {
				return Response::json(trans('Langcore::global.CannotBeDeleted'), 404);
			}
		}
	}
	public function viewcontact($id){
		$admin = User::with(['permissions'=>function($query){
			$query->select('id','name');
		}])->where('id',Auth::user()->id)->first();
		$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')?"https://":"http://";
		$contact = Contact::with(['part','customer','reply'=>function($query){
			$query->with(['auth'=>function($query){
				$query->with(['permissions'=>function($query){
					$query->select('id','name');
				}]);
			}])->orderByDesc('id');
		}])->where('id',$id)->first();
		$contact->increment('read', 1);
		$authname = ($admin->firstname && $admin->lastname)?$admin->lastname.' '.$admin->firstname:$admin->username;
		$quote = '<small><br />
				<br />
				----------<br />
				Best regards,<br />
				<br />
				'.$authname.'<br />
				'.$admin->permissions->name.'<br />
				<br />
				E-mail: '.$admin->email.'<br />
				Website: '.$link.$_SERVER['HTTP_HOST'].'<br />
				<br />
				--------------------------------------------------------------------------------<br />
				<strong>From:</strong> '.$contact->customer->fullname.' ['.$contact->customer->email.']<br />
				<strong>Sent:</strong> '.$contact->created_at.'<br />';
				if ($contact->part) {
					$quote .= '<strong>To:</strong> '.$contact->part->title.'<br />';
				}
				$quote .= '<strong>Subject:</strong> '.$contact->title.'<br />
				<br />
				'.$contact->messenger.'</small>';
		$data = ['contact'=>$contact,'quote'=>$quote];
		return view('contact::admin.viewcontact',$data);
	}
	public function delcontact(Request $request){
		$id = $request->id;
		$contact = Contact::with(['reply'])->where('id',$id)->first();
		if (count($contact->reply)==0) {
			if ($contact->delete()) {
				return Response::json(trans('Langcore::global.DelSuccess'), 200);
			} else {
				return Response::json(trans('Langcore::global.CannotBeDeleted'), 404);
			}
		} else {
			return Response::json(trans('Langcore::global.CannotBeDeleted'), 404);
		}
	}
	public function sendreply(Request $request,$id){
		$rules = [
			'messenger' => 'required'
		];
        $messages = [
        	'required' => trans('validation.required',['attribute'=>''])
        ];
        $Validator = Validator::make($request -> all(), $rules, $messages);
        if ($Validator -> fails()) {
            return redirect() -> back() -> withErrors($Validator) -> withInput();
        } else {
        	$contact = Contact::with(['customer'])->where('id',$id)->first();

        	$reply = New ReplyContact;
        	$reply->authid = Auth::user()->id;
        	$reply->contactid = $id;
        	$reply->messenger = $request->messenger;
        	$reply->save();

        	if (AdminFunc::checksmtp() == 'true') {
	        	$email = new SendReply($contact,$request->messenger);
			    Mail::to($contact->customer->email)->send($email);
        	}
        	
        	if ($reply) {
        		return redirect()->back() -> with('success', trans('Langcore::global.SaveSuccess'));
        	}
        }
	}
}
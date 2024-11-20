<?php

namespace Modules\Contact\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Contact\Entities\Contact;
use Modules\Contact\Entities\CustomerContact;
use Modules\Contact\Entities\PartsContact;
use Modules\Contact\Entities\PartsContactEmail;
use Modules\Contact\Entities\ReplyContact;
use Modules\Contact\Mail\SendContact;
use Redirect,Auth,View,Storage,Theme,CFglobal,ThemesFunc,Validator,Carbon,AdminFunc,Response,Image,Mail;

class ContactController extends Controller
{
    public function main(){
        $seometa = [
            'title'=>AdminFunc::ReturnModule('Contact', 'title'),
            'description'=>AdminFunc::ReturnModule('Contact', 'description'),
            'keyword'=>AdminFunc::ReturnModule('Contact', 'keywords'),
            'image'=>AdminFunc::ReturnModule('Contact', 'bgmod'),
            'created_at'=>AdminFunc::ReturnModule('Contact', 'created_at'),
            'updated_at'=>AdminFunc::ReturnModule('Contact', 'updated_at'),
            'canonical'=>1
        ];
        ThemesFunc::SEOMeta($seometa,'article');
        $parts = PartsContact::pluck('title','id')->all();
        $arraymap = ['address' =>CFglobal::cfn('site_address')];
        $map = getgooglemap($arraymap);
        $data = [
            'parts'=>$parts,
            'map'=>(env('GOOGLE_MAP_KEY')&&$map)?$map['geometry']['location']:[]
        ];
        return FileViewTheme('Contact','main',$data);
    }
    public function getformcontact(){
        $parts = PartsContact::pluck('title','id')->all();
        $data = [
            'parts'=>$parts
        ];
        return FileViewTheme('Contact','getformcontact',$data);
    }
    public function submitcontact(Request $request){
        $vldcapcha = (env('RECAPTCHA_SECRET_KEY') && env('RECAPTCHA_SITE_KEY'))?'required|recaptcha':'';
        $rules = [
            'fullname'=>'required',
            'mobile'=>'required',
            'email'=>'required',
            'title'=>'required',
            'messenger'=>'required',
            'g-recaptcha-response' => $vldcapcha
        ];
        $messages = [
            'required' => trans('validation.required',['attribute'=>'']),
            'g-recaptcha-response.required'=>trans('Langcore::global.NotConfirmedCaptcha'),
            'g-recaptcha-response.captcha'=>trans('Langcore::global.IncorrectCaptcha')
        ];
        $Validator = Validator::make($request -> all(), $rules, $messages);
        if ($Validator -> fails()) {
            return redirect() -> back() -> withErrors($Validator) -> withInput();
        } else {
            $findcustomer = CustomerContact::where('mobile','LIKE','%'.$request->mobile.'%')->orwhere('email','LIKE','%'.$request->email.'%')->first();
            $customer = (!$findcustomer)?New CustomerContact:$findcustomer;
            $customer->fullname = $request->fullname;
            $customer->mobile = $request->mobile;
            $customer->email = $request->email;
            $customer->save();

            $contact = New Contact;
            $contact->title = $request->title;
            $contact->customerid = (!$findcustomer)?$customer->id:$findcustomer->id;
            $contact->partid = $request->partid;
            $contact->messenger = $request->messenger;
            $contact->ip = AdminFunc::getIp();
            $contact->save();

            $datacontact = array_merge(json_decode($customer,true),json_decode($contact,true));
            $part = PartsContact::with(['partsemail'])->where('id',$contact->partid)->first();

            $partemail = collect(PartsContactEmail::with(['user'=>function($query){
                $query->select('id','email');
            }])->where('partid',$contact->partid)->select('userid','sendemail')->get())->pluck('user.email')->all();
            
            if (AdminFunc::checksmtp() == 'true') {
                if ($part) {
                    $email = new SendContact($datacontact);
                    $sendemail = Mail::to($part->email);
                    if ($partemail) {
                        $sendemail->cc($partemail);
                    }
                    $sendemail->send($email);
                }
            }

            return redirect()->route('contact.web.sendsuccess')->with('success', trans('Langcore::global.SaveSuccess'));
        }
    }
    public function sendsuccess(){
        $seometa = [
            'title'=>AdminFunc::ReturnModule('Contact', 'title'),
            'description'=>AdminFunc::ReturnModule('Contact', 'description'),
            'keyword'=>AdminFunc::ReturnModule('Contact', 'keywords'),
            'image'=>AdminFunc::ReturnModule('Contact', 'bgmod'),
            'created_at'=>AdminFunc::ReturnModule('Contact', 'created_at'),
            'updated_at'=>AdminFunc::ReturnModule('Contact', 'updated_at'),
            'canonical'=>1
        ];
        ThemesFunc::SEOMeta($seometa,'article');
        $data = [];
        return FileViewTheme('Contact','sendsuccess',$data);
    }
}

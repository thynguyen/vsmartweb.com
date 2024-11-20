<?php

namespace Modules\ServicePack\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ServicePack\Entities\ServicePack;
use Modules\ServicePack\Entities\SVPReg;
use Modules\ServicePack\Entities\SVPTransaction;
use Modules\ServicePack\Entities\SVPTransLog;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Auth,AdminFunc;
use App\User;

class ServicePackController extends Controller
{
    public function main()
    {
        $servicepacks = ServicePack::where('active',1)->get();
        $data = ['servicepacks'=>$servicepacks];
        return FileViewTheme('ServicePack','main',$data);
    }
    public function registerservice($packcode='null'){
        if (Auth::guest()) {        
        	$servicepack = ServicePack::pluck('title','code')->all();
            $gender = ['M'=>'Mr','F'=>'Ms'];
            $paymentcycle = [
                '1'=>'1 '.transmod('ServicePack::Month'),
                '3'=>'3 '.transmod('ServicePack::Month'),
                '6'=>'6 '.transmod('ServicePack::Month'),
                '12'=>'1 '.transmod('ServicePack::Year'),
                '24'=>'2 '.transmod('ServicePack::Year'),
                '36'=>'3 '.transmod('ServicePack::Year'),
                '48'=>'4 '.transmod('ServicePack::Year'),
                '60'=>'5 '.transmod('ServicePack::Year')
            ];
    		$infomem = [];
    		if (Auth::check()) {
    			$infomem = Auth::user();
    		}
        	$data = [
        		'servicepack'=>$servicepack,
        		'infomem'=>$infomem,
                'paymentcycle'=>$paymentcycle,
                'gender'=>$gender,
                'packcode'=>$packcode
        	];
        	return FileViewTheme('ServicePack','registerservice',$data);
        } else {
            return redirect()->route('servicepack.web.main');
        }
    }
    public function postregisterservice(Request $request,$packcode='null'){
        $vldcapcha = (env('RECAPTCHA_SECRET_KEY') && env('RECAPTCHA_SITE_KEY'))?'required|recaptcha':'';
    	$rules = ['g-recaptcha-response' => $vldcapcha];
        $messages = [
            'required' => trans('validation.required',['attribute'=>'']),
            'g-recaptcha-response.required'=>trans('Langcore::global.NotConfirmedCaptcha'),
            'g-recaptcha-response.captcha'=>trans('Langcore::global.IncorrectCaptcha')
        ];
        $Validator = Validator::make($request -> all(), $rules, $messages);
        if ($Validator -> fails()) {
            return redirect() -> back() -> withErrors($Validator) -> withInput();
        } else {
        	$servicepack = ServicePack::with(['slug'])->where('code',$request->servicepack)->first();

	        $this->validator($request->all())->validate();
	        event(new Registered($user = $this->create($request->all())));

            $active = ($request->servicepack == 'c59186477' || $request->servicepack == 'b24ce0cd3')?1:0;
            User::where('id', $user->id)->update(['active'=>$active]);

            $price = ($servicepack->price_sale > 0)?$servicepack->price_sale:$servicepack->price;
            $total = $price*$request->expired_at;
            $expiredat = Carbon::now()->addMonths($request->expired_at);
            $maxid = intval(SVPTransaction::max('id'))+1;
            $transcode = vsprintf('%06s',$maxid);

    		$svptransact = New SVPTransaction;
    		$svptransact->userid = $user->id;
    		$svptransact->svp_code = $servicepack->code;
    		if ($servicepack->code == 'c59186477' || $servicepack->code == 'b24ce0cd3') {
                $svptransact->status = 1;
    			$svptransact->expired_at = null;
                $svptransact->transpay_code = 'Free Account';
                $svptransact->timeout = null;
    		} else {
                $svptransact->status = 0;
                $svptransact->expired_at = $expiredat;
                $svptransact->transpay_code = 'Pending';
                $svptransact->timeout = $request->expired_at;
    		}
            $svptransact->price = $total;
            $svptransact->trans_ip = request()->ip();
            $svptransact->trans_code = $transcode;
    		$svptransact->save();

            if ($servicepack->code == 'c59186477' || $servicepack->code == 'b24ce0cd3') {
                $svpreg = New SVPReg;
                $svpreg->userid = $user->id;
                $svpreg->svp_code = $servicepack->code;
                $svpreg->expired_at = Null;
                $svpreg->save();

                $translog = New SVPTransLog;
                $translog->status = 1;
                $translog->transid = $svptransact->id;
                $translog->note = 'Free Account';
                $translog->handler = $user->id;
                $translog->save();

                return redirect()->route('members.web.main')->with('success', transmod('ServicePack::SignUpSuccess'));
            } else {
                $translog = New SVPTransLog;
                $translog->status = 0;
                $translog->transid = $svptransact->id;
                $translog->handler = $user->id;
                $translog->save();

                $numyear = $request->expired_at/12;
                $paymentcycle =($numyear >= 1)?$numyear.' '.transmod('ServicePack::Year'):$expiredat.' '.transmod('ServicePack::Month');
            	$response = \VNPay::purchase([
                    'vnp_TxnRef' => time(),
                    'vnp_OrderType' => 130005,
                    'vnp_OrderInfo' => transmod('ServicePack::OrderInfo',['servicepack'=>$servicepack->title,'expiredat'=>$paymentcycle]).'-'.trans('Langcore::global.Account').' '.$user->username,
                    'vnp_IpAddr' => request()->ip(),
                    'vnp_Amount' => $total*100,
                    'vnp_ReturnUrl' => route('servicepack.web.checkpay',['userid'=>$user->id,'tradid'=>$svptransact->id,'code'=>$servicepack->code,'expired'=>$expiredat]),
                ])->send();

                if ($response->isRedirect()) {
                    session()->flash('paymentservice', 1);
                    $redirectUrl = $response->getRedirectUrl();
                    return redirect($redirectUrl);
                }
            }
        }
    }
    public function checkpay(Request $request,$userid,$tradid,$code,$expired){
        $response = \VNPay::completePurchase()->send();
        if (session('paymentservice')==1) {
            if ($response->isSuccessful()) {

                $svpr = (Auth::check())?SVPReg::where('userid',$userid)->first():false;
                $svpreg = ($svpr)?$svpr:New SVPReg;
                $svpreg->userid = $userid;
                $svpreg->svp_code = $code;
                $svpreg->expired_at = $expired;
                $svpreg->save();

                SVPTransaction::where('id',$tradid)->update(['status'=>1,'transpay_code'=>$response->vnp_TransactionNo]);
                User::where('id',$userid)->update(['active'=>1]);
                $translog = New SVPTransLog;
                $translog->status = 1;
                $translog->transid = $tradid;
                $translog->handler = transmod('ServicePack::PaymentGateways');
                $translog->save();
                $data = ['response'=>$response,'expired'=>$expired];
                return FileViewTheme('ServicePack','checkpay',$data);
            } elseif ($response->isCancelled()) {
                SVPTransaction::where('id',$tradid)->first()->delete();
                User::where('id',$userid)->first()->delete();
                return redirect()->route('servicepack.web.main')->with('error', transmod('ServicePack::PaymentCanceled'));
            } else {
                return redirect()->route('servicepack.web.main')->with('error', transmod('ServicePack::ErrorCheckout'));
            }
        } else {
            return redirect()->route('servicepack.web.main');
        }
    }
    public function getservicepack(Request $request){
        $code = $request->servicepack;
        $expiredat = $request->expiredat;
        $numyear = $expiredat/12;
        $paymentcycle =($numyear >= 1)?$numyear.' '.transmod('ServicePack::Year'):$expiredat.' '.transmod('ServicePack::Month');
        $servicepack = ServicePack::where('code',$code)->first();
        $price = ($servicepack->price_sale > 0)?$servicepack->price_sale:$servicepack->price;
        $total = $price*$expiredat;
        $data = [
            'servicepack'=>$servicepack,
            'paymentcycle'=>($code == 'c59186477' || $code == 'b24ce0cd3')?false:$paymentcycle,
            'total'=>$total
        ];
        return FileViewTheme('ServicePack','getservicepack',$data);
    }
    protected function validator(array $data) {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255', 'unique:vsw_users'], 
            'email' => ['required', 'string', 'email', 'max:255', 'unique:vsw_users'], 
            'firstname' => ['required', 'string'], 
            'lastname' => ['required', 'string'], 
            'address' => ['required', 'string'], 
            'mobile' => ['required', 'string', 'unique:vsw_users'], 
            'password' => ['required', 'string', 'min:6', 'confirmed'], 
        ]);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data) {
        return User::create([
            'in_group' => 0, 
            'username' => $data['username'], 
            'email' => $data['email'], 
            'password' => Hash::make($data['password']), 
            'firstname' => $data['firstname'], 
            'lastname' => $data['lastname'], 
            'gender' => $data['gender'], 
            'avatar' => NULL, 
            'mobile' => $data['mobile'],
            'address' => $data['address'],
            'active' => 1, 
        ]);
    }
    protected function registered(Request $request, $user){}
}

<?php

namespace Modules\ServicePack\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ServicePack\Entities\ServicePack;
use Modules\ServicePack\Entities\SVPReg;
use Modules\ServicePack\Entities\SVPTransaction;
use Modules\ServicePack\Entities\SVPTransLog;
use Vsw\Permissions\Models\Permissions;
use Vsw\Permissions\Models\Roles;
use Core\Models\Slugs;
use Illuminate\Support\Str;
use Validator,AdminFunc,Response,Auth;
use App\User;

use Modules\ServicePack\FunctServicePack;

class AdminServicePackController extends Controller
{
    public function main()
    {
        $data = [];
        return FileViewTheme('ServicePack','main',$data,'admin');
    }
    public function addservicepack($id='null'){
        $servicepack = ServicePack::with(['slug'])->where('id',$id)->first();
        $listoption = ($id!='null')?json_decode($servicepack->listoption,true):[];
        $numrow = ($id!='null')?count($listoption):0;
        $data = [
            'servicepack'=>$servicepack,
            'listoption'=>$listoption,
            'numrow'=>$numrow
        ];
        return FileViewTheme('ServicePack','addservicepack',$data,'admin');
        
    }
    public function postaddservicepack(Request $request,$id='null'){
        $rules = [
            'title' => 'required|string'
        ];
        $messages = [
            'required' => trans('validation.required',['attribute'=>''])
        ];
        $Validator = Validator::make($request -> all(), $rules, $messages);
        if ($Validator -> fails()) {
            return redirect() -> back() -> withErrors($Validator) -> withInput();
        } else {
            $servicepack = ServicePack::with(['slug'])->where('id',$id)->first();
            $price = ($id=='null')?New ServicePack:$servicepack;
            $price->title = $request->title;
            $price->description = $request->description;
            $price->listoption = json_encode($request->listoption);
            $price->icon = $request->icon;
            $price->code = substr(md5($request->title), 0, -23);
            $price->price = ($request->price)?$request->price:0;
            $price->price_sale = ($request->price_sale)?$request->price_sale:0;
            $price->discounts = ($request->discounts)?$request->discounts:0;
            $price->popular = ($request->popular)?$request->popular:0;
            $price->contact = ($request->contact)?$request->contact:0;
            if ($id=='null') {
                $weight = ServicePack::max('weight');
                $maxWeight = intval($weight) + 1; 
                $price->weight = $maxWeight;
            }
            $price->save();

            if ($id == 'null' || empty($servicepack->slug)) {
                AdminFunc::PostSlug($request->slug,$servicepack->id,'ServicePack');
            } elseif ($request->slug != $servicepack->slug->slug) {
                AdminFunc::PostSlug($request->slug,$servicepack->id,'ServicePack',$servicepack->slug->id);
            }
            if ($price) {
                return redirect()->back() -> with('success', trans('Langcore::global.SaveSuccess'));
            }
        }
    }
    public function changeweight(Request $request){
        $idrow = ServicePack::where('id',$request->id)->first();
        if ($idrow) {
            $rows = ServicePack::where('id','!=',$request->id)->orderBy('weight', 'asc')->pluck('id');
            $weight = 0;
            foreach ($rows as $rowid) {
                $weight++;
                if ($weight == $request->newweight) {
                    $weight++;
                }
                ServicePack::where('id',$rowid)->update(['weight'=>$weight]);
            }
            ServicePack::where('id',$request->id)->update(['weight'=>$request->newweight]);
            return Response::json(trans('Langcore::language.SuccessChangeWeight'), 200);
        }
        return Response::json(trans('Langcore::language.ErrorChangeWeight'), 400);
    }
    public function activeprice(Request $request) {
        $id = $request->id;
        $dbprice = ServicePack::where('id', $id);
        $idprice = $dbprice -> first();
        if ($idprice) {
            $act = ($idprice['active'] == 1) ? 0 : 1;
            $dbprice -> update(['active' => $act]);
            $messenger = ($idprice['active'] == 1) ? trans('Langcore::global.CancelActive') : trans('Langcore::global.SuccessfulActive');
            return Response::json($messenger, 200);
        }
        return Response::json('Error', 404);
    }
    public function delServicePack(Request $request){
        $id = $request->id;
        $servicepack = ServicePack::where('id',$id)->first();
        if ($servicepack) {
            if ($servicepack->delete()) {
                return Response::json(trans('Langcore::global.DelSuccess'), 200);
            }
        }
        return Response::json(trans('Langcore::global.CannotBeDeleted'), 404);
    }

    public function transactionmanagement(){
        $data = [];
        return FileViewTheme('ServicePack','transactionmanagement',$data,'admin');
    }
    public function infouser($id){
        $user = User::find($id);
        $data = ['user'=>$user];
        return FileViewTheme('ServicePack','infouser',$data,'admin');
    }
    public function viewtrans($id){
        $trans = SVPTransaction::with(['svpack','user','log'=>function($query){
            $query->with(['handl']);
        }])->where('id',$id)->first();
        $trans->increment('readtrans', 1);
        $status = [
            2=>transmod('ServicePack::PaymentCanceled'),
            0=>transmod('ServicePack::PendingPayments'),
            1=>transmod('ServicePack::SuccessfulTransaction')
        ];
        $data = [
            'trans'=>$trans,
            'status'=>$status
        ];
        return FileViewTheme('ServicePack','viewtrans',$data,'admin');
    }
    public function postviewtrans(Request $request,$id){
        $status = $request->status;
        $note = $request->note;
        $transpaycode = 'VSW'.mt_rand(1000, 9999).Str::random(3);
        $trans = SVPTransaction::where('id',$id);
        $datatrans = $trans->first();
        if ($datatrans) {
            $trans->update([
                'status'=>$status,
                'note'=>$note,
                'transpay_code'=>$transpaycode
            ]);
            if ($status == 1) {
                User::where('id',$datatrans->userid)->update(['active'=>1]);
            }

            $translog = New SVPTransLog;
            $translog->status = $status;
            $translog->transid = $id;
            $translog->note = $note;
            $translog->handler = Auth::user()->id;
            $translog->save();

            return redirect()->route('servicepack.admin.transactionmanagement')->with('success', trans('Langcore::global.SaveSuccess'));
        } else {
            return redirect()->back()->with('warning', 'ERROR');
        }
        
    }
    public function listmodulelimit(Request $request){
        $id = $request->id;
        $roles = Roles::where('per_id',$id)->get();
        $data = ['roles'=>$roles];
        return FileViewTheme('ServicePack','listmodulelimit',$data,'admin');
    }
}

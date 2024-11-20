<?php

namespace Modules\InterfacePackage\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\InterfacePackage\Entities\InterfaceCat;
use Modules\InterfacePackage\Entities\Interfaces;
use Modules\InterfacePackage\Entities\Sentiment;
use Validator,AdminFunc,Response,Auth,ThemesFunc,CFglobal;

class InterfacePackageController extends Controller
{
    public function main()
    {
        $seometa = [
            'title'=>AdminFunc::ReturnModule('InterfacePackage', 'title'),
            'description'=>AdminFunc::ReturnModule('InterfacePackage', 'description'),
            'keyword'=>AdminFunc::ReturnModule('InterfacePackage', 'keywords'),
            'image'=>AdminFunc::ReturnModule('InterfacePackage', 'bgmod'),
            'created_at'=>AdminFunc::ReturnModule('InterfacePackage', 'created_at'),
            'updated_at'=>AdminFunc::ReturnModule('InterfacePackage', 'updated_at'),
            'canonical'=>1
        ];
        ThemesFunc::SEOMeta($seometa,'article');
        if (CFglobal::cfn('displayinterface','InterfacePackage') == 'showall') {
            $data = [];
            return FileViewTheme('InterfacePackage','main',$data);
        } elseif (CFglobal::cfn('displayinterface','InterfacePackage') == 'showbycat') {
            $data = [];
            return FileViewTheme('InterfacePackage','showbycat',$data);
        }
    }
    public function detail($slug){
        $interface = Interfaces::with(['cat','servicepack','comments','vote','authsentiment','sentiment','sentimentlike','sentimentdislike'])->where('slug',$slug)->where('active',1)->first();
        if ($interface) {
            $interface->increment('views', 1);
            $interface->content = content_img_mxw(htmlspecialchars_decode($interface->content));
            $interface->keywords = json_decode($interface->keyword,true);
            $interface->canonical = 1;
            $rate = $interface->vote->pluck('vote');
            $interface->rate = ThemesFunc::PoinVote($rate);
            $data = ['interface'=>$interface];
            ThemesFunc::SEOMeta($interface,'article');
            return FileViewTheme('InterfacePackage','detail',$data);
            // dd($interface);
        } else {
            return abort(404);
        }
    }
    public function sentiment(Request $request){
        $type = $request->type;
        $id = $request->id;
        if (Auth::check()) {
            if ($type == 'undo') {
                $sentiment = Sentiment::where('interfaceid',$id)->where('userid',Auth::user()->id)->delete();
                if ($sentiment) {
                    $mes = ['status'=>'success','mes'=>transmod('InterfacePackage::UndoSuccess')];
                } else {
                    $mes = ['status'=>'error','mes'=>'Error'];
                }
            } else {
                $sentiment = New Sentiment;
                $sentiment->interfaceid = $id;
                $sentiment->userid = Auth::user()->id;
                $sentiment->sentiment = $type;
                $sentiment->save();
                if ($sentiment) {
                    if ($type == 'like') {
                        $mes = ['status'=>'success','mes'=>transmod('InterfacePackage::LikeSuccess')];
                    } elseif ($type == 'dislike') {
                        $mes = ['status'=>'success','mes'=>transmod('InterfacePackage::DisLikeSuccess')];
                    }
                } else {
                    $mes = ['status'=>'error','mes'=>'Error'];
                }
            }
        } else {
            $mes = ['status'=>'warning','mes'=>transmod('InterfacePackage::SignInPerform')];
        }
        return $mes;
    }
    public function viewcat($slug){
        $interfacecat = InterfaceCat::where('slug',$slug)->first();
        $data = [
            'interfacecat'=>$interfacecat
        ];
        return FileViewTheme('InterfacePackage','viewcat',$data);
    }
    public function getitemtempcat($id,$slug){
        $interfacecat = Interfaces::where('catid',$id)->orderByDesc('id')->limit(6)->get();
        $data = [
            'interfacecat'=>$interfacecat,
            'slug'=>$slug
        ];
        return FileViewTheme('InterfacePackage','itemtempcat',$data);
    }
}

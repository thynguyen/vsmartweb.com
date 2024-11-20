<?php

namespace Vsw\Themes\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Redirect,Auth,View,Storage,Theme,CFglobal,ThemesFunc,ModulesFunc,Validator,Carbon,File,Artisan,Exception,AdminFunc,ZipArchive,Response,Log;
use Vsw\Themes\Models\DBWidget;
use Vsw\Themes\Models\Layout;
use Vsw\Modules\Models\ModFunc;
use Vsw\Modules\Models\Modules;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ThemesController extends Controller
{
    
    public function AdminToolBar(){
        return view(CFglobal::cfn('admintheme').'::layouts.admintoolbar');
    }
    public function index(){
        $themes['listthemes'] = ThemesFunc::getAllThemes();
        return view('System.Themes.index',$themes);
    }
    public function ActiveTheme($theme){
        return ThemesFunc::ActTheme($theme);
    }
    public function DeleteTheme($theme){
        return ThemesFunc::DelTheme($theme);
    }
    public function UpZipTheme(Request $request)
    {
        $rules = [ 
            'filetheme' => 'required|mimes:zip|max:5120',
        ];
        $messages = [
            'filetheme.required' => trans('Langcore::global.EmptyUploadFile'),
            'filetheme.mimes' => trans('Langcore::global.DoNotSupportFormat'),
            'filetheme.max' => trans('Langcore::global.ErrorMaxFilesize',['filesize' => '5MB']),
        ];
        $Validator = Validator::make($request->all(), $rules, $messages);
        if ($Validator -> fails()) {
            return redirect() -> back() -> withErrors($Validator) -> withInput();
        } else {
            $file = $request->filetheme;
            $basethemes = base_path('Themes');
            $nametheme = str_replace('.'.$file->getClientOriginalExtension(), '', $file->getClientOriginalName());
            if ( in_array($nametheme,scan_folder($basethemes))) {
                return Response::json(trans('Langcore::themes.ErrorThemeAlreadyExists'), 400);
            } else {
                $zip = new ZipArchive;
                $res = $zip->open($file->getRealPath());
                if ($res === TRUE) {
                    $zip->extractTo($basethemes);
                    $zip->close();
                    if (File::exists($basethemes . DIRECTORY_SEPARATOR . $nametheme . '/theme.json')) {
                        if (File::exists($basethemes . DIRECTORY_SEPARATOR . $nametheme . '/assets')) {
                            if (!File::exists(public_path('Themes') . DIRECTORY_SEPARATOR . $nametheme)) {
                                File::makeDirectory(public_path('Themes').'/'.$nametheme, 0755, true);
                            }
                            File::moveDirectory($basethemes . DIRECTORY_SEPARATOR . $nametheme . '/assets',public_path('Themes').'/'. $nametheme . '/assets',$overwrite = true);
                        }
                        Log::info(trans('Langcore::themes.LogUploadSuccessTheme',['name'=>Auth::user()->username,'title'=>$nametheme]));
                        return Response::json(route('AdminThemes'), 200);
                    } else {
                        File::deleteDirectory($basethemes . DIRECTORY_SEPARATOR . $nametheme);
                        return Response::json(trans('Langcore::themes.ErrorUpThemeEmptyJson'), 400);
                    }
                } else {
                    return Response::json(trans('Langcore::global.ErrorEmptyFile'), 400);
                }
            }
        }
    }
    //Layout
    public function LayoutSetup(){
        $listmod = Modules::where('locale',LaravelLocalization::getCurrentLocale())->where('active',1)->pluck('pathmod');
        $listmods = array_merge(['Index-Home'],json_decode($listmod, true));
        foreach ($listmods as $modname) {
            $datafunc = ModFunc::where('in_module',$modname)->where('locale',LaravelLocalization::getCurrentLocale())->get();
            $data = [];
            foreach ($datafunc as $funcmod) {
                $data[] = $funcmod;
            }
            $datafuncinfo[$modname] = $data;
        }
        $modlayout['listmod']=$datafuncinfo;
        $modlayout['listlayout'] = ThemesFunc::GetCoverLayout();
        return view('System.Themes.layoutsetup',$modlayout);
    }
    public function PostLayoutSetup(Request $request){
        foreach ($request->func as $func_id => $layout_theme) {
            $finđblayout = Layout::where('func_id',$func_id)->where('theme',CFglobal::cfn('theme'))->where('locale',LaravelLocalization::getCurrentLocale())->first();
            $dbmodfuc = ModFunc::where('id',$func_id)->first();
            if ($finđblayout) {
                $dblayout = $finđblayout;
            } else {
                $dblayout = new Layout;
            }
            $dblayout->func_id = $func_id;
            $dblayout->funcname = ($func_id>0)?strtolower($dbmodfuc['func_name']):'indexhome';
            $dblayout->layout = $layout_theme;
            $dblayout->module = ($func_id>0)?strtolower(AdminFunc::GetPrefixMod($dbmodfuc['in_module'])):'Root';
            $dblayout->theme = CFglobal::cfn('theme');
            $dblayout->locale = LaravelLocalization::getCurrentLocale();
            $dblayout->save();
        }
        return redirect()->back()->with('success', trans('Langcore::global.SaveSuccess'));
    }
    //Widget
    public function Widget(){
        $widget['groupwidget'] = ThemesFunc::getAllWidget();
        $widget['listallwg'] = ThemesFunc::GetListAllWidget();
        return view('System.Themes.widget',$widget);
    }
    public function AddWidgetSite($id = 'null',$placewidget='',$mod='',$widgetfile=''){
        $dbwidget = DBWidget::where('id',$id)->where('theme',CFglobal::cfn('theme'))->where('locale',LaravelLocalization::getCurrentLocale())->first();
        $widget['id'] = ($dbwidget)? $id : null;
        $widget['widget'] = $dbwidget;
        $widget['placewidget'] = ($placewidget)?$placewidget:$dbwidget['widgetgroup'];
        $widget['modname'] = ($mod)?$mod:$dbwidget['position'];
        $widget['widgetfile'] = ($widgetfile)?$widgetfile:$dbwidget['widgetname'];
        $widget['widgetgroup'] = ThemesFunc::GetInfoTheme()['widgetgroup'];
        $widget['coverwidget'] = ThemesFunc::GetCoverWidget();
        $widget['modules'] = ModulesFunc::getAllmodule();
        $widget['widgetmod'] = ThemesFunc::GetListWidget(($widget['modname'] == 'Core' or !$widget['modname'])?'Core':'Modules',$widget['modname']);
        $widget['configwidget'] = ThemesFunc::GetInfoWidget('htmlconfig',$widget['modname'],$widget['widgetfile'],$dbwidget['id']);
        $widget['descwidget'] = ThemesFunc::GetInfoWidget('desc',$widget['modname'],$widget['widgetfile']);
        if ($widget['widgetgroup']) {
            return view('System.Themes.addwidget',$widget);
        } else {
            return redirect()->route('Widget')-> with('error', trans('Langcore::themes.ErrorEmptyWidgetGroup'));
        }
    }
    public function PostAddWidget(Request $request,$id = 'null'){
        $rules = [ 
            'widgetgroup' => 'required|string',
            'widgetname' => 'required|string',
            'position' => 'required|string',
        ];
        $messages = [
            'widgetgroup.required' => trans('Langcore::global.error_title'),
            'widgetname.required' => trans('Langcore::global.error_title'),
            'position.required' => trans('Langcore::global.error_title'),
        ];
        $Validator = Validator::make($request -> all(), $rules, $messages);
        if ($Validator -> fails()) {
            return redirect() -> back() -> withErrors($Validator) -> withInput();
        } else {
            $widgetdb = DBWidget::where('id',$id)->where('theme',CFglobal::cfn('theme'))->where('locale',LaravelLocalization::getCurrentLocale())->first();
            if ($widgetdb) {
                $dbwidget = $widgetdb;
            } else {
                $dbwidget = new DBWidget;        
            }
            $dbwidget->title = ($request->title)?$request->title:$request->widgetname;
            $dbwidget->description = $request->description;
            $dbwidget->widgetgroup = $request->widgetgroup;
            $dbwidget->widgetname = $request->widgetname;
            $dbwidget->position = $request->position;
            $dbwidget->coverwidget = $request->coverwidget;
            $dbwidget->theme = CFglobal::cfn('theme');
            $dbwidget->groupview = $request->groupview;
            $dbwidget->async = ($request->widgetname=='ProductCart')?0:1;

            if($request->configwidgetval){
                $cfwidgetval =  $request->configwidgetval;
                // $cfwidgetkey =  $request->configwidgetkey;
                // if(count($cfwidgetval) > count($cfwidgetkey))
                //     $count = count($cfwidgetkey);
                // else $count = count($cfwidgetval);
                // for($i = 0; $i < $count; $i++){
                //     $configwidget[$cfwidgetkey[$i]] = $cfwidgetval[$i];
                // }
                // $dbwidget->configwidget = json_encode($configwidget);
                $dbwidget->configwidget = json_encode($cfwidgetval);
            } else {
                $dbwidget->configwidget = NULL;
            }
            $dbwidget->locale = LaravelLocalization::getCurrentLocale();
            $dbwidget->custom_id = $request->custom_id;
            $dbwidget->custom_class = $request->custom_class;
            if (!$widgetdb) { 
                $weight = DBWidget::where('theme',CFglobal::cfn('theme'))->where('locale',LaravelLocalization::getCurrentLocale())->where('widgetgroup',$request->widgetgroup)->max('weight');
                $maxWeight = intval($weight) + 1;
                $dbwidget->weight = $maxWeight;
            }
            $dbwidget->save();
            Log::info('['.Auth::user()->username.'] '.trans('Langcore::themes.SuccessAddWidget',['widget'=>$request->widgetname]));
            return redirect()->back()->with('success', trans('Langcore::themes.SuccessAddWidget',['widget'=>$request->widgetname]));
        }
    }
    public function SelectWidget($module = 'null'){
        $widget['widgetmod'] = ThemesFunc::GetListWidget(($module == 'Core')?'Core':'modules',$module);
        $showlistwidget = ($widget['widgetmod'])? view('System.Themes.selectwidget',$widget):'';
        return $showlistwidget;
    }
    public function GetJsonWidget($position='null',$widgetname='null',$id='null'){
        return ThemesFunc::GetInfoWidget('htmlconfig',$position,$widgetname,$id);
    }
    public function DeleteWidget($id,$widgetgroup){
        return ThemesFunc::DelWidget($id,$widgetgroup);
    }
    public function StartToolWidget(){
        if (session('toolwidget') == 'on') {
            session()->forget('toolwidget');
        } else {
            session(['toolwidget' => 'on']);
        }
        return redirect()->back();
    }
    public function ChangeListWidget(Request $request){
        $weight = $request->weight;
        $place = $request->place;
        $wggroup = $request->wggroup;
        if (!empty($weight) && !empty($wggroup)) {
            $listwidget = DBWidget::where('theme',CFglobal::cfn('theme'))->where('locale',LaravelLocalization::getCurrentLocale())->where('widgetgroup','!=',$wggroup)->whereIn('id', $weight)->pluck('id');
            if($listwidget) {
                $findwidet = DBWidget::where('id', $listwidget);
                $findwidet->update(['weight'=>'2147483647','widgetgroup'=>$wggroup]);
                
                $oldweights = DBWidget::where('theme',CFglobal::cfn('theme'))->where('locale',LaravelLocalization::getCurrentLocale())->where('widgetgroup',$place)->pluck('id');
                if ($oldweights) {
                    foreach ($oldweights as $key => $weightold) {
                        $dbweight = DBWidget::find( $weightold );
                        if( $dbweight ) {
                            $dbweight->weight = $key + 1;
                            $dbweight->save();
                        }
                    }
                }

                $newsweight = DBWidget::where('theme',CFglobal::cfn('theme'))->where('locale',LaravelLocalization::getCurrentLocale())->where('widgetgroup',$wggroup)->pluck('id');
                if ($newsweight) {
                    foreach ($newsweight as $key => $weightnew) {
                        $dbweight = DBWidget::find( $weightnew );
                        if( $dbweight ) {
                            $dbweight->weight = $key + 1;
                            $dbweight->save();
                        }
                    }
                }

                return Response::json('ok', 200);
            } else {
               abort(404, trans('Langcore::global.Error404'));
            }
        } else {
            if (count($weight)>0) {
                for ($i=0; $i < count($weight); $i++) {
                    $finddb = DBWidget::where('theme',CFglobal::cfn('theme'))->where('locale',LaravelLocalization::getCurrentLocale())->where('id',$weight[$i]); 
                    $finddb->update(['weight'=>$i + 1]);
                }
                return Response::json('Ok', 200);
            } else {
                abort(404, trans('Langcore::global.Error404'));
            }
        }
    }
}

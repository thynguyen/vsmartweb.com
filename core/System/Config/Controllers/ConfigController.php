<?php

namespace Vsw\Config\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Redirect,Auth,View,Storage,Theme,CFglobal,ThemesFunc,Validator,File,AdminFunc;
use Vsw\Config\Models\Config;
use Vsw\Modules\Models\Modules;
use Modules\Pages\Entities\Pages;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
class ConfigController extends Controller
{
    public function cfredirect()
    {
            return Redirect::route('siteconfig');
    }
    public function config() {
        // Debugbar::info(ThemesFunc::getAllThemes());
        $allmod = Modules::where('active',1)->pluck('title','pathmod')->all();
        $listmod = $allpage = [];
        foreach ($allmod as $key => $mod) {
            $modulePath = base_path('modules').'/'.$key.'/Routes';
            if (File::exists($modulePath . "/web.php") && $key != 'Pages') {
                $listmod[$key] = $mod;
            }
        }
        if (AdminFunc::ReturnModule('Pages','active')==1) {
            $allpage = Pages::with(['slug'=>function($query){
                $query->select('slug','item_id');
            },'content'])->where('active',1)->get();
            $allpage = collect($allpage)->pluck('title','slug.slug')->all();
        }
        $data = ['listmod'=>array_merge($listmod,$allpage)];
        return view('System.Config.configindex',$data);
    }
    public function globalconfig() {
        $data['adminthemes'] = collect(ThemesFunc::getAllThemes())->where('type','admin')->pluck('name','name');
        $data['envConfig'] = CFglobal::getEnvContent();
        $data['select_app_env'] = ['local'=>'Local','development'=>'Development','qa'=>'Qa','production'=>'Production'];
        $data['mail_encryption'] = ['null'=>'None','ssl'=>'SSL','tsl'=>'TSL'];
        $data['list_maildriver'] = ['smtp'=>'SMTP','mailgun'=>'Mailgun','sparkpost'=>'SparkPost','sendinblue'=>'Sendinblue'];
        $data['list_cachedriver'] = ['file'=>'FILE','redis'=>'REDIS'];
        $data['list_mapdriver'] = ['googlemap'=>'Google Map','mapbox'=>'Map Box'];
        $data['fileanalyticsgg'] = File::exists(storage_path('app/analytics/googleapiconnect.json'));
        $data['close_site'] = [
            '0'=>trans('Langcore::config.CloseSite0'),
            '1'=>trans('Langcore::config.CloseSite1'),
            '2'=>trans('Langcore::config.CloseSite2'),
            '3'=>trans('Langcore::config.CloseSite3'),
        ];
        return view('System.Config.configglobal', $data);
    }
    public function configimg($namedata) {
        $data['value'] = $namedata;
        return view('System.Config.configimg',$data);
    }
    public function siteConfig(Request $request){
        $rules = [ 
            'sitename' => 'required|string',
        ];
        $messages = [
            'sitename.required' => trans('Langcore::config.EmptyWebsiteName'),
        ];
        $Validator = Validator::make($request -> all(), $rules, $messages);
        if ($Validator -> fails()) {
            return redirect() -> back() -> withErrors($Validator) -> withInput();
        } else {
            $configarray = array();
            $configarray['sitename'] = $request->sitename;
            $configarray['site_description'] = $request->site_description;
            $configarray['site_keywords'] = $request->site_keywords;
            $configarray['site_warning'] = $request->site_warning;
            $configarray['moddefault'] = $request->moddefault;
            foreach ($configarray as $config_name => $config_value) {
                $finddb = Config::where('config_name',$config_name)->where('lang',LaravelLocalization::getCurrentLocale());
                if(empty($finddb->first())){
                    $config = new Config;
                    $config->lang = LaravelLocalization::getCurrentLocale();
                    $config->module = 'global';
                    $config->config_name = $config_name;
                    $config->config_value = $config_value;
                    $config->save();
                } else {                
                    $config = $finddb->update(['config_value'=>$config_value]);
                }
            }
            return back() -> with('success', lang('content.success_config'));
        }
    }
    public function PostGlobalConfig(Request $request){
        $rules = [];
        $messages = [];
        $Validator = Validator::make($request -> all(), $rules, $messages);
        if ($Validator -> fails()) {
            return redirect() -> back() -> withErrors($Validator) -> withInput();
        } else {
            $configenv = CFglobal::UpdateOrEditENV($request->env);

            $configarray = array();
            $configarray['admintheme'] = $request->admintheme;
            $configarray['site_email'] = $request->site_email;
            $configarray['site_phone'] = $request->site_phone;
            $configarray['site_address'] = $request->site_address;
            $configarray['site_logo'] = str_replace(url('/'), '', $request->site_logo);
            $configarray['site_favicon'] = str_replace(url('/'), '', $request->site_favicon);
            $configarray['site_latitude'] = $request->site_latitude;
            $configarray['site_longitude'] = $request->site_longitude;
            $configarray['extend_head'] = $request->extend_head;
            $configarray['extend_footer'] = $request->extend_footer;
            $configarray['follow'] = json_encode($request->follow);
            foreach ($configarray as $config_name => $config_value) {
                if(empty(Config::find($config_name))){
                    $config = new Config;
                } else {                
                    $config = Config::find($config_name);
                }
                $config->lang = 'sys';
                $config->module = 'global';
                $config->config_name = $config_name;
                $config->config_value = $config_value;
                $config->save();
            }
            if ($configenv == true) {
                if ($request->adminprefix != env('ADMIN_PREFIX')) {
                    return redirect($request->env['ADMIN_PREFIX'].'/config/globalconfig')->with('success', lang('content.success_config'));
                } else {
                    return back() -> with('success', lang('content.success_config'));
                }
            } else {
                return back() -> with('error', 'error');
            }
        }
    }
    public function Uploadimg(Request $request,$namedata){
        $rules = [ 
            $namedata => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ];
        $messages = [
            $namedata.'.required' => trans('Langcore::global.EmptyUploadFile'),
            $namedata.'.mimes' => trans('Langcore::global.DoNotSupportFormat'),
            $namedata.'.max' => trans('Langcore::global.ErrorMaxFilesize',['filesize' => '1MB']),
        ];
        $Validator = Validator::make($request -> all(), $rules, $messages);
        if ($Validator -> fails()) {
            return redirect() -> back() -> withErrors($Validator) -> withInput();
        } else {
            $configarray = array();
            $siteimg = $namedata.'_'.time().'.'.$request->$namedata->getClientOriginalExtension();
            $configarray[$namedata] = $siteimg;
            $request->$namedata->storeAs('uploads/config', $siteimg);
            foreach ($configarray as $config_name => $config_value) {
                $finddb = Config::where('config_name',$config_name)->where('lang',Auth::user()->locale);
                if(empty($finddb->first())){
                    $config = new Config;
                    $config->lang = 'sys';//Auth::user()->locale
                    $config->module = 'global';
                    $config->config_name = $config_name;
                    $config->config_value = $config_value;
                    $config->save();
                } else {                
                    $config = $finddb->update(['config_value'=>$config_value]);
                }
            }
            return back() -> with('success', lang('content.success_config'));
        }
    }
    public function getlisticon($idkey,$name,$valdata='null'){
        return AdminFunc::GetListIcons($valdata,$idkey,$name);
    }
    public function updatecore(){
        $data = [];
        return view('System.Config.updatecore',$data);
    }
}

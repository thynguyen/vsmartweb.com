<?php

namespace Vsw\Modules\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Redirect,Auth,View,Storage,Theme,CFglobal,ThemesFunc,ModulesFunc,Validator,Carbon,File,Exception,AdminFunc,ZipArchive,Response,Module;
use Vsw\Modules\Models\Modules;
use Vsw\Modules\Models\ModFunc;
use Illuminate\Support\Facades\Log;

class ModulesController extends Controller
{
	public function index(){
		$listmodule = ModulesFunc::getAllmodule();
        $data = ['listmodule'=>$listmodule];
        return FileViewTheme('Modules','listmodule',$data,'admin');
	}
    public function AddModule()
    {
        $data = [];
        return FileViewTheme('Modules','addmodule',$data,'admin');
    }
    public function UnzipModule(Request $request)
    {
        $rules = [ 
            'filemod' => 'required|mimes:zip|max:5120',
        ];
        $messages = [
            'filemod.required' => trans('Langcore::global.EmptyUploadFile'),
            'filemod.mimes' => trans('Langcore::global.DoNotSupportFormat'),
            'filemod.max' => trans('Langcore::global.ErrorMaxFilesize',['filesize' => '5MB']),
        ];
        $Validator = Validator::make($request->all(), $rules, $messages);
        if ($Validator -> fails()) {
            return redirect() -> back() -> withErrors($Validator) -> withInput();
        } else {
            $file = $request->filemod;
            $basemodules = base_path('modules');
            $namemod = str_replace('.'.$file->getClientOriginalExtension(), '', $file->getClientOriginalName());
            if ( in_array($namemod,scan_folder($basemodules))) {
                return Response::json(trans('Langcore::modules.ErrorModuleAlreadyExists'), 400);
            } else {
                $zip = new ZipArchive;
                $res = $zip->open($file->getRealPath());
                if ($res === TRUE) {
                    $zipopenfolder = str_replace('/', '', $zip->getNameIndex(0));
                    $zip->extractTo($basemodules);
                    $zip->close();
                    if (in_array($zipopenfolder,scan_folder($basemodules)) && File::exists($basemodules . DIRECTORY_SEPARATOR . $namemod . '/module.json')) {
                        if (File::exists($basemodules . DIRECTORY_SEPARATOR . $namemod . '/Resources/lang')) {
                            foreach (language()->allowed() as $code => $name) {
                                $filelang = '/Resources/lang/'.$code.'/'.strtolower($namemod).'.php';
                                $filecorelang = '/Langs/'.$code.'/'.strtolower($namemod).'.php';
                                if (File::exists($basemodules . DIRECTORY_SEPARATOR . $namemod . $filelang)) {
                                    File::move($basemodules . DIRECTORY_SEPARATOR . $namemod . $filelang,base_path('core').$filecorelang);
                                }
                            }
                        }
                        
                        $modulepack = Module::find($namemod);
                        $modulepack->enable();
                        Log::info(trans('Langcore::modules.LogUploadSuccessModule',['name'=>Auth::user()->username,'title'=>$namemod]));
                        return Response::json(route('infomod',$namemod), 200);
                    } else {
                        File::deleteDirectory($basemodules . DIRECTORY_SEPARATOR . $zipopenfolder);
                        return Response::json(trans('Langcore::modules.ErrorUpModEmptyJson'), 400);
                    }
                } else {
                    return Response::json(trans('Langcore::global.ErrorEmptyFile'), 400);
                }
            }
        }
    }
    public function InstallModule($mod)
    {
        $basemodule = base_path('modules') . DIRECTORY_SEPARATOR . $mod;
        $path = $basemodule . '/module.json';
        if (File::exists($path)) {
        	if (!empty($mod)) {
                $module = get_file_data($path);
                $modfunc = ModFunc::where('in_module',$mod)->where('locale',app()->getLocale())->get();
                foreach ($modfunc as $key => $funcmod) {
                    $getdbfunc[$funcmod['func_name']] = $funcmod['func_custom_name'];
                }
    			$row['modjson'] = (count($modfunc)>0)?$getdbfunc:$module['funcmod'];
                $dbmod = Modules::where('pathmod', $mod)->where('locale', app()->getLocale())->first();
    			$row['module'] = $dbmod;
        		$row['path'] = $mod;        
                $row['list_icons'] = AdminFunc::GetListIcons($dbmod['icon'],'iconvalue','icon');
            	return view('System.Modules.infomod', $row);
            }
        } else {
            return Redirect::route('listmodules');
        }
    }
    public function PostInstallModule(Request $request,$modname)
    {
        $rules = [ 
            'title' => 'required|string',
        ];
        $messages = [
            'title.required' => trans('Langcore::global.error_title'),
        ];
        $Validator = Validator::make($request -> all(), $rules, $messages);
        if ($Validator -> fails()) {
            return redirect() -> back() -> withErrors($Validator) -> withInput();
        } else {
            $message = '';

            $basemodule = base_path('modules') . DIRECTORY_SEPARATOR . $modname;
            $path = $basemodule . '/module.json';
            $modjson = get_file_data($path);
            $moddb = Modules::where('pathmod', $modname)->where('locale', app()->getLocale())->first();

            $message .= ModulesFunc::PostModModel($modname,$moddb,$request->all());

            if (!is_null($request->func_custom)) {
                $message .= ModulesFunc::PostModFuc($modname,$modjson,$request->func_custom);
            }
            if ($modname != $moddb['pathmod']) {
	        	$message .= ModulesFunc::InstallMod($modname);
            	Log::info(trans('Langcore::modules.LogInstallSuccessModule',['name'=>Auth::user()->username,'title'=>$request->title]));
                $message .= "\n".trans('Langcore::modules.MesInstallSuccessModule',['module'=>$modname])."\n";
                $case = ($modname != $moddb['pathmod'])?'install':'update';
                $data = [
                    'case'=>$case,
                    'message'=>$message 
                ];
            	return $data;
            } else {
                return redirect()->route('listmodules')-> with('success', trans('Langcore::global.SaveSuccess'));
            }
        }
    }
    public function reinstallmod(Request $request){
        $modname = $request->module;
        ModulesFunc::ReInstallMod($modname);
        return Response::json('Module '.$modname.' reinstalled successfully!', 200);
    }
    public function UninstallModule(Request $request)
    {
        $module = $request->module;
        return ModulesFunc::UninstallMod($module);
    }
    public function ActiveModule($module)
    {
        return ModulesFunc::ActiveMod($module);
    }
    public function DeleteModule($module)
    {
        return ModulesFunc::DeleteMod($module);
    }
	
}

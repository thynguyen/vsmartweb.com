<?php
namespace Vsw\Modules;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Symfony\Component\Console\Output\BufferedOutput;
use Vsw\Modules\Models\Modules;
use Vsw\Modules\Models\ModFunc;
use Vsw\Themes\Models\Layout;
use Vsw\Permissions\Models\Roles;
use Vsw\Comment\Models\Comment;
use Core\Models\Slugs;
use Vsw\Config\Models\Config;
use Vsw\Language\Models\Translation;
use File,Exception,Artisan,Validator,Response,Log,Auth,CFglobal,AdminFunc,Module,LanguageFunc;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
class ModulesFunc
{
    public function getFiles($folder = false)
    {
        $basemodule = base_path('modules') . DIRECTORY_SEPARATOR . $folder; 
        $files = glob($basemodule.'/Migrations/*.php');
        $files = array_reverse($files);
        $files = array_filter($files, 'is_file');
        if ($folder && is_array($files)) {
            foreach ($files as $k => $file) {
                $file_name = $namefile = str_replace('.php', '', basename($file));
                $files[$k] = [
                    'file_name'     => $file_name
                ];
            }
        }

        return array_values($files);
    }

    public function getAllmodule()
    {
    	$modules = [];
        $modulePath = base_path('modules');
        foreach (scan_folder($modulePath) as $folder) { 
            $basemodule = $modulePath . DIRECTORY_SEPARATOR . $folder;
            $path = $basemodule . '/module.json';
            if (File::exists($path)) {
                $module = get_file_data($path);
                $datamod = Modules::where('pathmod', $folder)->where('locale', LaravelLocalization::getCurrentLocale())->first();
                if (!empty($module)) {
                    $module['path'] = $folder;
                    $module['name'] = ($datamod && $datamod['active'] == 1)?AdminFunc::ReturnModule($folder,'title'):$folder;
                    $module['description'] = ($datamod)?AdminFunc::ReturnModule($folder,'description'):'';
                    $module['keywords'] = ($datamod)?AdminFunc::ReturnModule($folder,'keywords'):'';
                    $module['alias'] = ($datamod)?AdminFunc::GetPrefixMod($folder):strtolower($folder);
                    if (File::exists(module_path($folder, '/screenshot.png'))) {
                        $module['image'] = base64_encode(File::get(module_path($folder, '/screenshot.png')));
                    } else {
                        $module['image'] = base64_encode(File::get(public_path('images/logo_vsw.png')));
                    }
                    $module['active'] = $datamod['active'];
                    $module['pathmod'] = $datamod['pathmod'];
                    $module['locale'] = $this->localemod($folder);
                    $module['activeroute'] = ($datamod['pathmod'])? route('uninstallmod',$folder) : route('infomod',$folder);
            	   $modules[$folder] = $module;
                }            
            }
        }
        return $modules;
    }
    public function localemod($mod){
        $locales = Modules::where('pathmod', $mod)->pluck('locale');
        return $locales;
    }
    public function InstallMod($mod)
    {
        $modulepack = Module::find($mod);
        $modulepack->enable();
        $basemodule = '/modules/' . $mod . '/Database/Migrations';
        $baseseed = '/modules/' . $mod . '/Database/Seeders';
        $modulepathlang = module_path($mod, '/Resources/lang');
        $modulepathassets = module_path($mod, '/Resources/assets');
        $outputLog = new BufferedOutput;
        $message = '';

        $message .= $this->migrateModule($outputLog,$basemodule)."\n";

        if (count(scan_folder(module_path($mod, '/Database/Seeders')))>0) {
            if (File::isDirectory(module_path($mod, '/Database/Seeders'))) {
                $fileseed = glob(module_path($mod,'/Database/Seeders').'/*.php');
                $fileseed = array_reverse($fileseed);
                $fileseed = array_filter($fileseed, 'is_file');
                foreach ($fileseed as $files => $file) {
                    $fileseed  = pathinfo( $file );
                    $message .= $this->seedModule($outputLog,$mod,$fileseed[ 'filename' ])."\n";
                }
            }
        }
        if (File::exists($modulepathlang)) {
            foreach (scan_folder($modulepathlang) as $code) {
                if (File::exists($modulepathlang.'/'.$code)) {
                    $filelanggr = glob($modulepathlang.'/'.$code.'/*.php');
                    $filelanggr = array_reverse($filelanggr);
                    $filelanggr = array_filter($filelanggr, 'is_file');
                    foreach ($filelanggr as $files => $file) {
                        $info  = pathinfo( $file );
                        $group = $info[ 'filename' ];
                        $translations = include( $file );
                        foreach ( Arr::dot( $translations ) as $key => $value ) {
                            LanguageFunc::importTranslation( $key, $value, $code, $group );
                        }
                    }
                }
            }
            $message .= trans('Langcore::modules.MesSuccessRegisterModLang',['module'=>$mod])."\n";
        }
        if(File::exists($modulepathassets)){
            foreach (scan_folder($modulepathassets) as $asset) {
                if (File::exists($modulepathassets.'/'.$asset)) {
                    if ($asset != '.gitkeep') {
                        if (!File::exists(public_path('modules') .'/'.$asset.'/'. strtolower($mod))) {
                            File::makeDirectory(public_path('modules') .'/'.$asset.'/'. strtolower($mod), 0755, true);
                        }
                        foreach (scan_folder($modulepathassets.'/'.$asset) as $fileasset) {
                            File::copyDirectory($modulepathassets.'/'.$asset.'/'.$fileasset,public_path('modules/'.$asset.'/'.strtolower($mod)).'/'.$fileasset);
                            if (File::exists($modulepathassets.'/'.$asset)) {
                                $filelanggr = glob($modulepathassets.'/'.$asset.'/*.*');
                                $filelanggr = array_reverse($filelanggr);
                                $filelanggr = array_filter($filelanggr, 'is_file');
                                foreach ($filelanggr as $files => $file) {
                                    $pathfile  = pathinfo( $file );
                                    $filename = $pathfile['basename'];
                                    // File::copy($modulepathassets.'/'.$asset.'/'.$filename,public_path('modules/'.$asset.'/'.strtolower($mod)).'/'.$filename);
                                    $base_file = base_path('modules/'.$mod.'/Resources/assets/'.$asset.'/'.$filename);
                                    if (in_array($pathfile['extension'], ['css','js'])) {
                                        $stub_module = base_path('core/System/Modules/Commands/stubs/assets/module_'.$asset.'.stub');
                                        $raw = str_replace('$BASE_FILE$', $base_file, file_get_contents($stub_module));
                                        $file = public_path('modules/'.$asset.'/'.strtolower($mod)).'/'.$filename.'.php';
                                    } else {
                                        $raw = file_get_contents($base_file);
                                        $file = public_path('modules/'.$asset.'/'.strtolower($mod)).'/'.$filename;
                                    }
                                    File::put($file,$raw);
                                }
                            }
                        }
                    }
                }
            }

            $message .= trans('Langcore::modules.MesSuccessActiveAssetsModule',['module'=>$mod])."\n";
        }
        return $message;
    }
    public function ReInstallMod($mod)
    {
        $basemodule = '/modules' . DIRECTORY_SEPARATOR . $mod . DIRECTORY_SEPARATOR . 'Database'.DIRECTORY_SEPARATOR.'Migrations';
        if (count(scan_folder(base_path($basemodule)))>0) {
            if (File::isDirectory(base_path($basemodule))) {
                Artisan::call('migrate:refresh', [
                    '--force' => true,
                    '--path' => $basemodule,
                ]);
            }
        }
    }
    public function UninstallMod($mod)
    {
        $datamod = Modules::where('pathmod', $mod)->where('locale', LaravelLocalization::getCurrentLocale())->first();
        $modulepack = Module::find($mod);
        $modprefix = AdminFunc::GetPrefixMod($mod);
        if($datamod) {
            $datamod->delete();
            $modulepack->disable();
            Translation::where(['group' => strtolower($mod)])->delete();
            $basemodule = '/modules' . DIRECTORY_SEPARATOR . $mod . DIRECTORY_SEPARATOR . 'Database'.DIRECTORY_SEPARATOR.'Migrations';
            $path = base_path('modules') . DIRECTORY_SEPARATOR . $mod . '/module.json';
            $module = get_file_data($path);
            if (count(scan_folder(base_path($basemodule)))>0) {
                if (File::isDirectory(base_path($basemodule))) {
                    Artisan::call('migrate:reset', [
                        '--force' => true,
                        '--path' => $basemodule,
                    ]);
                }
            }
            if ($module['dataslug']) {
                foreach ($module['dataslug'] as $dbslug) {
                    Slugs::where('module',$dbslug)->where('locale',LaravelLocalization::getCurrentLocale())->delete();
                }
            }
            Comment::where('module',$module['name'])->where('locale',LaravelLocalization::getCurrentLocale())->delete();
            Config::where('module',$module['name'])->where('lang',LaravelLocalization::getCurrentLocale())->delete();
            ModFunc::where('in_module',$mod)->where('locale',LaravelLocalization::getCurrentLocale())->delete();
            Layout::where('module',$modprefix)->where('theme',CFglobal::cfn('theme'))->where('locale',LaravelLocalization::getCurrentLocale())->delete();
            Log::info(trans('Langcore::modules.LogUninstallSuccessModule',['name'=>Auth::user()->username,'title'=>$mod]));
            foreach (scan_folder(public_path('modules')) as $asset) {
                File::deleteDirectory(public_path('modules') .'/'. $asset.'/'.strtolower($mod));
                File::deleteDirectory(public_path('minified') .'/'. $asset.'/modules/'.strtolower($mod));
            }
            return Response::json(trans('Langcore::global.SuccessfulUninstall').' Module "<strong>'.$mod.'</strong>"', 200);
        }
        return Response::json(trans('Langcore::global.ErrorUninstall'), 400);
    }
    public function ActiveMod($module)
    {
        $dbmod = Modules::where('pathmod', $module)->where('locale', LaravelLocalization::getCurrentLocale());
        $datamod = $dbmod->first();
        $act = ($datamod['active'] == 1) ? 0 : 1;
        $messenger = ($datamod['active'] == 1) ? trans('Langcore::global.CancelActive').' Module "<strong>'.$module.'</strong>"' : trans('Langcore::global.SuccessfulActive').' Module "<strong>'.$module.'</strong>"';
        $dbmod->update(['active'=>$act]);
        $modulepack = Module::find($module);
        $modulepack->enable();
        Log::info(Auth::user()->username.' '.$messenger);
        return Response::json($messenger, 200);
    }
    public function DeleteMod($module)
    {
        $dbmod = Modules::where('pathmod', $module)->first();
        if ($dbmod) {
            return Response::json(trans('Langcore::modules.ErrorDelModule',['module'=>$module]), 400);
        } else {
            if ($module == 'Members') {
                return Response::json(trans('Langcore::modules.ErrorDelModuleMember'), 400);
            } else {
                $modulepack = Module::find($module);
                $modulepack->delete();
                Log::info(trans('Langcore::modules.LogDeleteSuccessModule',['name'=>Auth::user()->username,'title'=>$module]));
                return Response::json(trans('Langcore::modules.SuccessfulDelMod',['module'=>$module]), 200);
            }
        }
    }
    public function PostModModel($modname,$moddb,$request){
        $message = '';
        $dbmodule = ($modname == $moddb['pathmod'])?$moddb:new Modules;
        $dbmodule->title = $request['title'];
        $dbmodule->pathmod = $modname;
        $dbmodule->description = $request['description'];
        $dbmodule->keywords = $request['keywords'];
        $dbmodule->bgmod = str_replace(url('/'), '', $request['bgmod']);
        $dbmodule->icon = $request['icon'];
        $dbmodule->groupview = (!empty($request['groupview']))?$request['groupview']:null;
        $dbmodule->locale = LaravelLocalization::getCurrentLocale();
        if ($modname != $moddb['pathmod']) { 
            $weight = Modules::max('weight');
            $maxWeight = intval($weight) + 1;
            $dbmodule->weight = $maxWeight;
        }
        $dbmodule->active = $request['active'];
        $dbmodule->save();
        if ($dbmodule) {
            $message = trans('Langcore::modules.MesSuccessRegisterModule',['module'=>$modname])."\n";
        }
        return $message;
    }
    public function PostModFuc($modname,$modjson,$funccustom){
        $message = '';
        foreach ($funccustom as $key => $func) {
            $getfunc = ModFunc::where('func_name',$key)->where('in_module',$modname)->where('locale', LaravelLocalization::getCurrentLocale())->first();
            $dbmodfunc = ($getfunc)?$getfunc:new ModFunc;
            $dbmodfunc->func_name = $key;
            $dbmodfunc->func_custom_name = $func;
            $dbmodfunc->in_module = $modjson['name'];
            $dbmodfunc->locale = LaravelLocalization::getCurrentLocale();
            $dbmodfunc->save();
            $message .= trans('Langcore::modules.MesSuccessRegisterModFunc',['func'=>$func])."\n";
        }
        return $message;
    }
    private static function migrateModule(BufferedOutput $outputLog,$basemodule){
        if (count(scan_folder(base_path($basemodule)))>0) {
            if (File::isDirectory(base_path($basemodule))) {
                try {
                    Artisan::call('migrate', [
                        '--force' => true,
                        '--path' => $basemodule,
                    ], $outputLog);
                    return $outputLog->fetch();
                } catch (Exception $e) {
                    return static::response($e->getMessage(), $outputLog);
                }
            }
        }
    }
    private static function seedModule(BufferedOutput $outputLog,$mod,$filename){
        if (!File::exists(module_path($mod,'/Database/Seeders/'.$filename))) {
            try {
                Artisan::call('db:seed', [
                    '--force' => true,
                    '--class' => 'Modules\\'.$mod.'\\Database\Seeders\\'.$filename
                ], $outputLog);
                return $outputLog->fetch();
            } catch (Exception $e) {
                return static::response($e->getMessage(), $outputLog);
            }
        }
    }
    private static function response($message, BufferedOutput $outputLog)
    {
        return [
            'status' => 'error',
            'message' => $message,
            'dbOutputLog' => $outputLog->fetch(),
        ];
    }
    public function ModValue($mod,$name){
        $modval = Modules::where('pathmod',$mod)->first();
        return @$modval[$name];
    }
}
<?php
namespace Vsw\Language\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Vsw\Language\Models\Language;
use Vsw\Language\Models\Translation;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Events\Dispatcher;
use Vsw\Language\Events\TranslationsExportedEvent;
use Illuminate\Support\Arr;
use Redirect,Auth,View,Storage,Theme,CFglobal,ThemesFunc,ModulesFunc,Validator,Carbon,File,Artisan,Exception,AdminFunc,ZipArchive,Response,LanguageFunc;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
/**
 * 
 */
class LanguageController extends Controller
{
	protected $app;
	protected $files;
    protected $events;
    protected $config;
	public function __construct( Application $app, Filesystem $files, Dispatcher $events)
    {
        $this->app            = $app;
        $this->files          = $files;
        $this->events         = $events;
        $this->config         = '';
    }
	public function index(){
		$lang['alllang'] = Language::orderBy('weight', 'asc')->get();
		$lang['num'] = count($lang['alllang']);
		return view('System.Language.index', $lang);
	}

	public function AddLang($id='null',$locale='null'){
		if (!empty($id)) {
			$data['lang'] = Language::find($id);
		}
		$data['locale'] = LanguageFunc::GetLocale('locale',$locale);
		$data['selectflag'] = ($data['locale'])?$data['locale']['flag']:$data['lang']['flag'];
		$data['selectcountry'] = ($data['locale'])?$data['locale']['code']:$data['lang']['code'];
		$data['id'] = $id;
		return view('System.Language.addlang',$data);
	}
	public function PostAddLang(Request $request,$id='null',$locale='null'){
		$rules = [];
		$messages = [];
		$Validator = Validator::make($request->all(),$rules,$messages);
		if ($Validator->fails()) {
			return redirect()->back()->withErrors($Validator)->withInpit();
		} else {
			if ($id=='null'&& Language::where('locale',$request->locale)->first()) {
				return redirect()->back()->with('warning', trans('Langcore::language.ErrorAlreadyExistLang',['name'=>$request->name]));
			} else {
				$langid = Language::find($id);
				$dblang = ($langid)?$langid: new Language;
				$dblang->name = $request->name;
				$dblang->locale = $request->locale;
				$dblang->script = $request->script;
				$dblang->native = $request->native;
				$dblang->regional = $request->regional;
				$dblang->flag = $request->flag;
				if ($id=='null') {
					$dblang->default = 0;
					$weight = Language::max('weight');
					$maxWeight = intval($weight)+1;
					$dblang->weight = $maxWeight;
				}
				$dblang->active = 1;
				$dblang->save();
				if (!File::exists(base_path('core/Langs') . DIRECTORY_SEPARATOR . $request->locale)) {
					File::makeDirectory(base_path('core/Langs') . DIRECTORY_SEPARATOR . $request->locale, 0755, true);
				}
				$this->ExportSupportedLocales();
	        	$mess = ($id>0) ? trans('Langcore::global.SaveSuccess') : trans('Langcore::global.AddSuccess') ;
	        	if ($id=='null') {
	        		return redirect($request->locale.'/admin/config/siteconfig')->with('success', $mess);
	        	} else {
	        		return redirect()->route('listlang')->with('success', $mess);
	        	}
			}
		}
	}
	public function DelLang($id,$locale){
		$dblang = Language::where('id',$id)->first();
		if ($dblang) {
			if (LaravelLocalization::getCurrentLocale() != $locale) {
				if ($dblang->delete()) {
					$pathlocale = base_path('core/Langs') . DIRECTORY_SEPARATOR . $dblang['locale'];
					if (File::exists($pathlocale)) {
						File::deleteDirectory($pathlocale);
					}
					$rowlang = Language::where('id','!=',$id)->where('active',1)->orderBy('weight', 'asc')->pluck('id');
					$weight = 0;
					foreach ($rowlang as $langid) {
						$weight++;
						Language::where('id',$langid)->update(['weight'=>$weight]);
					}

					$dbtrans = Translation::where(['locale' => $locale])->delete();
					$this->ExportSupportedLocales();
					$messenger = trans('Langcore::language.SuccessDelLang');
					return Response::json($messenger, 200);
				}
				return Response::json(trans('Langcore::language.ErrorDelLang'), 404);
			} else {
				return Response::json(trans('Langcore::language.ErrorDelLang'), 404);
			}
		}
		return Response::json(trans('Langcore::language.ErrorDelLang'), 404);
	}
	public function ActiveLang($id){
		$dblang = Language::where('id',$id);
		$idlang = $dblang->first();
		if ($idlang) {
			$act = ($idlang['active']==1)?0:1;
			$dblang->update(['active'=>$act]);
			$this->ExportSupportedLocales();
			$messenger = ($idlang['active'] == 1) ? trans('Langcore::global.CancelActive') : trans('Langcore::global.SuccessfulActive');
			return Response::json($messenger, 200);
		}
		return Response::json('Error', 404);
	}
	public function SetDefaultLang($id){
		$idlang = Language::where('id',$id);
		if ($idlang->first()) {
			Language::where('default',1)->update(['default'=>0]);
			$idlang->update(['default'=>1]);
			LanguageFunc::ExportConfigENV($idlang->first()['locale']);
			return Response::json(trans('Langcore::language.SuccessSetDefault'), 200);
		}
		return Response::json(trans('Langcore::language.ErrorSetDefault'), 400);
	}
	public function ChangeLangWeight($id,$newweight='null'){
		$idlang = Language::where('id',$id)->first();
		if ($idlang) {
			$rowlang = Language::where('id','!=',$id)->where('active',1)->orderBy('weight', 'asc')->pluck('id');
			$weight = 0;
			foreach ($rowlang as $langid) {
				$weight++;
				if ($weight == $newweight) {
					$weight++;
				}
				Language::where('id',$langid)->update(['weight'=>$weight]);
			}
			Language::where('id',$id)->update(['weight'=>$newweight]);
			return Response::json(trans('Langcore::language.SuccessChangeWeight'), 200);
		}
		return Response::json(trans('Langcore::language.ErrorChangeWeight'), 400);
	}
	public function GetLang($code='null'){
		$collection = collect(LanguageFunc::GetCountry());
		$collection = $collection->where('regional', $code);
		$findcountry = $collection->first();
		$flag = strtoupper(substr($code, -2));
		$localeexit = File::exists(base_path('core/Langs') . DIRECTORY_SEPARATOR . $collection->keys()->first());
		$findlang = ($localeexit)?1:0;
		$notefindlang = ($localeexit)?trans('Langcore::language.SuccessNoteFindLang'):trans('Langcore::language.ErrorNoteFindLang');
		$data = [
			'name'=>$findcountry['name'],
			'locale'=>$collection->keys()->first(),
			'code'=>$findcountry['regional'],
			'script'=>$findcountry['script'],
			'native'=>$findcountry['native'],
			'flag'=>$flag,
			'findlang'=>$findlang,
			'notefindlang'=>$notefindlang
		];
		return Response($data);
	}
	public function ImportLang(){
		return view('System.Language.importlang');
	}
	public function UnzipLang(Request $request)
    {
        $rules = [ 
            'filelang' => 'required|mimes:zip|max:5120',
        ];
        $messages = [
            'filelang.required' => trans('Langcore::global.EmptyUploadFile'),
            'filelang.mimes' => trans('Langcore::global.DoNotSupportFormat'),
            'filelang.max' => trans('Langcore::global.ErrorMaxFilesize',['filesize' => '5MB']),
        ];
        $Validator = Validator::make($request->all(), $rules, $messages);
        if ($Validator -> fails()) {
            return redirect() -> back() -> withErrors($Validator) -> withInput();
        } else {
            $file = $request->filelang;
            $baselangs = base_path('core/Langs');
            $localelang = str_replace('.'.$file->getClientOriginalExtension(), '', $file->getClientOriginalName());
            if (scan_folder($baselangs.'/'.$localelang)) {
                return Response::json(trans('Langcore::modules.ErrorModuleAlreadyExists'), 400);
            } else {
                $zip = new ZipArchive;
                $res = $zip->open($file->getRealPath());
                if ($res === TRUE) {
                    $zip->extractTo($baselangs);
                    $zip->close();
                    Log::info(trans('Langcore::modules.LogUploadSuccessModule',['name'=>Auth::user()->username,'title'=>$localelang]));
                    if (Language::where('locale',$localelang)->first()) {
                    	$route = route('listlang');
                    } else {
                    	$route = route('addlang',['id'=>'null','locale'=>$localelang]);
                    }
                    return Response::json($route, 200);
                } else {
                    return Response::json(trans('Langcore::global.ErrorEmptyFile'), 400);
                }
            }
        }
    }
	public function TranslateLang($locale='null',$group='null'){
		$datatrans = Translation::all();
		if (count($datatrans)>0) {
			if ($locale!= 'null') {
				$langdefault = 'en';
				$data['groups'] = Translation::groupBy('group')->select('group')->orderBy('group')->get()->pluck('group','group');

				$group = ($group == 'null')?'config':$group;
				$langs = Translation::whereIn('locale',[$langdefault,$locale])->where('group',$group)->orderBy('locale')->get();
				$showcontenlang = [];
				foreach ($langs as $showfile) {
					$showcontenlang[$showfile['key']][$showfile['locale']] = $showfile;
				}
				$data['showcontenlang'] = $showcontenlang;
		        $data['locales'] = ($locale == $langdefault)?[$langdefault]:[$langdefault,$locale];
		        $data['alllang'] = Language::orderBy('weight', 'asc')->get();
				$data['group'] = $group;
				$data['locale'] = $locale;
				$data['addkeylang'] = route('addkeylang',['locale'=>$locale,'group'=>$group]);
				$data['routeeditlang'] = route('editvaluelang',['group'=>$group]);
				return view('System.Language.translatelang',$data);
			} else {
				return redirect()->route('listlang');
			}
		} else {
			$routegetdatalang = route('getdatalang');
			return view('System.Language.getdatalang')->with('routegetdatalang',$routegetdatalang);
		}
	}
	public function GetDataLang(){
		$baselangs = base_path('core/Langs');
		$basemodlang = base_path('modules');
		foreach (scan_folder($baselangs) as $folder) {
			$filelanggr = glob($baselangs.'/'.$folder.'/*.php');
	        $filelanggr = array_reverse($filelanggr);
	        $filelanggr = array_filter($filelanggr, 'is_file');
	        foreach ($filelanggr as $files => $file) {
	        	$info  = pathinfo( $file );
                $group = $info[ 'filename' ];
	        	$translations = include( $file );
	        	foreach ( Arr::dot( $translations ) as $key => $value ) {
                    LanguageFunc::importTranslation( $key, $value, $folder, $group );
                }
	        }
		}
		foreach (scan_folder($basemodlang) as $module) {
			foreach (LaravelLocalization::getSupportedLocales() as $code => $name) {
				$filelang = '/Resources/lang/'.$code;
				if (File::exists($basemodlang . DIRECTORY_SEPARATOR . $module . $filelang)) {
					$filelanggr = glob($basemodlang . DIRECTORY_SEPARATOR . $module . $filelang.'/*.php');
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
		}
        return Response::json(trans('Langcore::language.SuccessImportTranslation'), 200);
	}
	public function EditValueLang(Request $request,$group = null)
    {
            $name = $request->name;
            $value = $request->value;
           	list($locale, $key) = explode('|', $name, 2);

            $translation = Translation::firstOrNew([
                'locale' => $locale,
                'group' => $group,
                'key' => $key,
            ]);
            $translation->value = (string) $value ?: null;
            $translation->status = Translation::STATUS_CHANGED;
            $translation->save();
            return array('status' => 'ok');
    }

    public function ExportLocaleLang($locale = null){
    	$tree = $this->makeTree( Translation::ofTranslatedLocale( $locale )->get() );
		$langsystem = config('modules.langsystem');
		if ($tree) {
			foreach ( $tree as $locales ) {
				foreach ($locales as $groups => $value) {
					if (in_array($groups, $langsystem)) {
						$basefile = base_path('core/Langs');
						$path = $basefile . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR . $groups . '.php';
					} else {
						$basefile = base_path('modules');
						$path = $basefile .'/'.ucfirst($groups).'/Resources/lang/'. $locale . '/' . $groups . '.php';
					}
	                $output = "<?php\n\nreturn " . var_export( $value, true ) . ";" . \PHP_EOL;
	                $this->files->put( $path, $output );
				}
	        }
	        Translation::ofTranslatedLocale( $locale )->update( [ 'status' => Translation::STATUS_SAVED ] );
	        return Response::json(trans('Langcore::language.SuccessExportLanguage'), 200);
		} else {
			return Response::json(trans('Langcore::language.ErrorExportLanguage'), 400);
		}
    }

    public function ExportGroupLang($group = null){
    	$tree = $this->makeTree( Translation::ofTranslatedGroup( $group )->get() );
		$basefile = base_path('core/Langs');
		foreach ( $tree as $locale => $groups ) {
            if ( isset( $groups[ $group ] ) ) {
                $translations = $groups[ $group ];

                $path = $basefile . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR . $group . '.php';

                $output = "<?php\n\nreturn " . var_export( $translations, true ) . ";" . \PHP_EOL;
                $this->files->put( $path, $output );
            }
        }
        Translation::ofTranslatedGroup( $group )->update( [ 'status' => Translation::STATUS_SAVED ] );
        return Response::json(trans('Langcore::language.SuccessExportLanguage'), 200);
    }

    protected function makeTree( $translations, $json = false )
    {
        $array = [];
        foreach ( $translations as $translation ) {
                Arr::set( $array[ $translation->locale ][ $translation->group ], $translation->key,
                    $translation->value );
        }

        return $array;
    }

    public function AddKeyLang($locale,$group) {
    	$dt['locale'] = $locale;
    	$dt['group'] = $group;
    	return view('System.Language.addkeylang',$dt);
    }
    public function PostAddKeyLang(Request $request,$locale,$group){
		$baselangs = base_path('core/Langs');
		foreach (scan_folder($baselangs) as $folder) {
			$dbtrans = new Translation;
			$dbtrans->locale = $folder;
			$dbtrans->group = $group;
			$dbtrans->key = $request->key;
			$dbtrans->save();
		}
        return redirect()->route('translatelang',['locale'=>$locale,'group'=>$group])->with('success', trans('Langcore::global.AddSuccess'));
    }
    public function DelKeyLang($group = null, $key){
    	$dbtrans = Translation::where('group',$group)->where('key',$key);
		if ($dbtrans->delete()) {
			$messenger = trans('Langcore::language.SuccessDelLang');
			return Response::json($messenger, 200);
		}
		return Response::json(trans('Langcore::language.ErrorDelLang'), 404);
    }
    public function ExportSupportedLocales(){
    	$langall = Language::ofLangLocale()->get();
		if ($langall) {
	    	$array = [];
	        foreach ( $langall as $key => $val ) {
	        	$array[$val->locale] = $val;
	        }
			$basefile = public_path();
			$path = $basefile.'/supportedLocales.json';
            $this->files->put( $path, json_encode($array) );
	        return $array;
		} 
    }
}
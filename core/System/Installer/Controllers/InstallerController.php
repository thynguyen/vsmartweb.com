<?php

namespace Installer\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Installer\InstallerFunc;
use Ixudra\Curl\Facades\Curl;
use Installer\Helpers\RequirementsChecker;
use Installer\Helpers\PermissionsChecker;
use Installer\Helpers\DatabaseManager;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use ThemesFunc,CFglobal,Exception;
use App\User;
   
class InstallerController extends Controller
{
	use RegistersUsers;
    /**
     * @var RequirementsChecker
     */
    protected $requirements;
    protected $permissions;
    private $databaseManager;

    /**
     * @param RequirementsChecker $checker
     */
    public function __construct(RequirementsChecker $requirementschecker,PermissionsChecker $permissionschecker,DatabaseManager $databaseManager)
    {
        $this->requirements = $requirementschecker;
        $this->permissions = $permissionschecker;
        $this->databaseManager = $databaseManager;
    }
	public function main(){
    	$seometa = [
			'title'=>trans('Langcore::installer.Installer'),
			'description'=>trans('Langcore::installer.WelcomeDescription'),
			'keyword'=>'install',
			'image'=>asset('images/logo_vsw.png'),
			'canonical'=>1
		];
		ThemesFunc::SEOMeta($seometa);
		$data = [];
		if (Cache('checklicense')['status']=='ok' && !empty(env('WEB_KEY'))) {
			return redirect()->route('installer.web.requirements');
		}
        return FileViewTheme('Installer','step.main',$data);
	}
	public function checklicense(Request $request){
		InstallerFunc::getEnvContent();
		$data = $request->all();
		$rls = $request->WEB_KEY;
		InstallerFunc::generateKey();
		$checkls = InstallerFunc::getls($rls);
		if (!is_null($checkls)) {
			$checkstatus = [
				'status'=>'ok',
				'message'=>trans('Langcore::installer.LicenseActive')
			];
		} else {
			$checkstatus = [
				'status'=>'null',
				'message'=>trans('Langcore::installer.LicenseNotWork')
			];
		}
		Cache::put('checklicense', $checkstatus);
		if (Cache('checklicense')['status']=='ok') {
			CFglobal::UpdateOrEditENV($data);
			return redirect()->route('installer.web.requirements');
		}
		return redirect()->back()->with('error', Cache('checklicense')['message']);
	}
	public function requirements(){
		$phpSupportInfo = $this->requirements->checkPHPversion(
            config('installer.core.minPhpVersion')
        );
        $requirements = $this->requirements->check(
            config('installer.requirements')
        );
		$data = [
			'phpSupportInfo'=>$phpSupportInfo,
			'requirements'=>$requirements
		];
		return FileViewTheme('Installer','step.requirements',$data);
	}
	public function permissions(){
		$permissions = $this->permissions->check(
            config('installer.permissions')
        );
		InstallerFunc::StorageLink();
		$data = ['permissions'=>$permissions];
		return FileViewTheme('Installer','step.permissions',$data);
	}
	public function database(){
		$dbconnection = [
			'mysql'=>'mysql',
			'sqlite'=>'sqlite',
			'pgsql'=>'pgsql',
			'sqlsrv'=>'sqlsrv'
		];
		$data = [
			'dbconnection'=>$dbconnection
		];
		return FileViewTheme('Installer','step.database',$data);
	}
	public function postdatabase(Request $request){
        $data = $request->all();
        $updateenv = CFglobal::UpdateOrEditENV($data);
        if ($updateenv) {
        	$checkconnect = InstallerFunc::checkDatabaseConnection($request);
	        if ($checkconnect) {
				return redirect()->route('installer.web.migratedata');
	        } else {
	        	return redirect()->back()->with('error', trans('Langcore::installer.ErrorConnectData'));
	        }
        } else {
	        return redirect()->back()->with('error', trans('Langcore::installer.ErrorConnectData'));
        }
	}
	public function migratedata(){
		$connectsql = $this->databaseManager->migrateAndSeed();
		Cache::put('messengeinstaller', $connectsql['dbOutputLog']);
		return redirect()->route('installer.web.configenv');
	}
	public function configenv(){
		$appenvironment = ['local'=>'Local','development'=>'Development','qa'=>'Qa','production'=>'Production'];
		$data = [
			'appenvironment'=>$appenvironment
		];
		return FileViewTheme('Installer','step.configenv',$data);
	}
	public function postconfigenv(Request $request){
        $data = $request->all();
        $updateenv = CFglobal::UpdateOrEditENV($data);
        if ($updateenv) {
			return redirect()->route('installer.web.createadmin');
        } else {
        	return 'error';
        }
	}
	public function createadmin(){
		$user = User::find(1);
		if ($user) {
			return redirect()->route('installer.web.finish');
		} else {
			$data = [];
			return FileViewTheme('Installer','step.createadmin',$data);
		}
	}
	public function postcreateadmin(Request $request){
        $this -> validator($request -> all()) -> validate();
        $this -> create($request -> all());
		return redirect()->route('installer.web.finish');
	}

	public function finish(){
		$messenger = Cache('messengeinstaller');
		$data = ['messenger'=>$messenger];
		return FileViewTheme('Installer','step.finish',$data);
	}
	public function postfinish(){
		Cache::forget('checklicense');
		Cache::forget('messengeinstaller');
		InstallerFunc::PutFileInstalled();
		ThemesFunc::ActTheme(config('installer.theme_default'));
		return redirect()->route('indexhome');
	}

    protected function validator(array $data) {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255', 'unique:vsw_users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:vsw_users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'], 
        ]);
    }
    protected function create(array $data) {
    	$messengeinstaller = Cache::get('messengeinstaller');
	    $useradmin = [
	    	'connectsql'=>$messengeinstaller,
	    	'useradmin'=>[
		    	'username'=>$data['username'], 
	            'email' => $data['email'], 
	            'password' => $data['password'],
	        ]
	    ];
		Cache::put('messengeinstaller', $useradmin);
        return User::create([
            'in_group' => 1, 
            'username' => $data['username'], 
            'email' => $data['email'], 
            'password' => Hash::make($data['password']), 
            'firstname' => $data['firstname'], 
            'lastname' => $data['lastname'], 
            'gender' => 'N', 
            'avatar' => null, 
            'birthday' => 0, 
            'mobile' => null,
            'address' => null,
            'website' => null,
            'facebook' => null,
            'skype' => null,
            'twitter' => null,
            'youtube' => null,
            'question' => null, 
            'answer' => null, 
            'active' => 1, 
        ]);
    }
}
<?php
namespace Core\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Redirect,Auth,View,Validator,Theme,CFglobal,AdminFunc,Analytics,Response;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Analytics\Period;
use Core\Models\Slugs;
use Carbon\Carbon;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller{
	use AuthenticatesUsers;
    protected $maxAttempts = 5;
    protected $decayMinutes = 15;
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }
    public function username()
    {
        return 'username';
    }
    public function __construct(){
        # parent::__construct();
    }
	public function redirect()
    {
        if (Auth::guest())
            return Redirect::route('dashboard');

        return Redirect::route('adminlogin');
    }
    public function getLogin(){
    	if (Auth::check()) {
			return redirect() -> route('dashboard');
		} else {
			return view('layouts.login');
		}
    }
    public function postLogin(Request $request) {
		$this->validateLogin($request);
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
    	$username = $request->username;
		if(filter_var($username, FILTER_VALIDATE_EMAIL)) {
		    $login = ['email' => $username, 'password' => $request->password,'active' => 1];
		} else {
		    $login = ['username' => $username, 'password' => $request->password,'active' => 1];
		}
        if (Auth::attempt($login)) {
			if (Auth::user()->in_group > 0) {
				if (Auth::user()->online == 0) {
					User::where('id',Auth::user()->id)->update(['online'=>'1']);
				}
				Log::info('['.Auth::user()->username.'] đăng nhập thành công');
				return redirect() -> route('dashboard')->with('success','Đăng nhập thành công');
			} else {
				Log::warning('['.$username.'] đăng nhập thất bại');
				Auth::logout();
				return back() -> with('error', 'Đăng nhập thất bại');
			}
		} else {
			Log::warning('['.$username.'] đăng nhập thất bại');
	        $this->incrementLoginAttempts($request);
	        return $this->sendFailedLoginResponse($request);
		}
	}
	public function getLogout()
    {
		User::where('id',Auth::user()->id)->update(['last_login'=>Carbon::now(),'last_ip'=>AdminFunc::getIp(),'online'=>'0']);
    	Log::info('['.Auth::user()->username.'] đăng xuất thành công');
    	session()->flush();
        Auth::logout();
        return redirect()->back()->with('warning','Bạn đã đăng xuất thành công');
    }

    public function filemanager()
    {
    	if (Auth::guest()) {
            return Redirect::route('adminlogin');
    	} else {
	        return View::make('System.FileManager.index');
	    }
    }
    
	public function check_slug(Request $request)
	{
	    $slug = SlugService::createSlug(Slugs::class, 'slug', $request->title);
    	return response()->json(['slug' => $slug]);
	}
	public function Changenewweight($table,$id,$newweight='null'){
		$idrow = DB::table($table)->where('id',$id)->first();
		if ($idrow) {
			$rows = DB::table($table)->where('id','!=',$id)->orderBy('weight', 'asc')->pluck('id');
			$weight = 0;
			foreach ($rows as $rowid) {
				$weight++;
				if ($weight == $newweight) {
					$weight++;
				}
				DB::table($table)->where('id',$rowid)->update(['weight'=>$weight]);
			}
			DB::table($table)->where('id',$id)->update(['weight'=>$newweight]);
			return Response::json(trans('Langcore::language.SuccessChangeWeight'), 200);
		}
		return Response::json(trans('Langcore::language.ErrorChangeWeight'), 400);
	}
	public function ChangeParentWeight($table,$id,$parentid,$newweight='null'){
		$idrow = DB::table($table)->where('id',$id)->where('parentid',$parentid)->first();
		if ($idrow) {
			$rows = DB::table($table)->where('id','!=',$id)->where('parentid',$parentid)->orderBy('weight', 'asc')->pluck('id');
			$weight = 0;
			foreach ($rows as $rowid) {
				$weight++;
				if ($weight == $newweight) {
					$weight++;
				}
				DB::table($table)->where('id',$rowid)->update(['weight'=>$weight]);
			}
			DB::table($table)->where('id',$id)->update(['weight'=>$newweight]);
			return Response::json(trans('Langcore::language.SuccessChangeWeight'), 200);
		}
		return Response::json(trans('Langcore::language.ErrorChangeWeight'), 400);
	}
}
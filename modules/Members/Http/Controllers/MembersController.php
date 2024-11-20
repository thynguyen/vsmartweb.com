<?php

namespace Modules\Members\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Str;
use App\User;
use Redirect, Auth, View, Storage, Theme, CFglobal, ThemesFunc, ModulesFunc, File, Artisan, Exception, AdminFunc, ZipArchive, Response, MembersFunc,Avatar,Socialite;
use Carbon\Carbon;
use SEOMeta;
use OpenGraph;
use Twitter;
## or
use SEO;

class MembersController extends Controller
{
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
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function main()
    {
        if (Auth::guest()) {
            $data = [];
            return FileViewTheme('Members','main',$data);
        } else {
            return Redirect::route('members.web.userpanel');
        }
    }
    public function postlogin(Request $request) {
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
            if (Auth::user()->online == 0) {
                User::where('id',Auth::user()->id)->update(['online'=>'1']);
            }
            return redirect() -> route('members.web.userpanel')->with('success',trans('Langcore::global.logged_in'));
        } else {
            $this->incrementLoginAttempts($request);
            return $this->sendFailedLoginResponse($request);
        }
    }
    public function register(){
        if (Auth::check()) {
            return Redirect::route('members.web.userpanel');
        } else {
            $data = [];
            return FileViewTheme('Members','register',$data);
        }
    }
    public function postregister(Request $request){
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request -> all())));
        $this->guard()->login($user);
        return $this->registered($request, $user) ? : redirect()->route('members.web.main');
    }
    public function userpanel(){
        $infomem = Auth::user();
        $infomem->name = ($infomem->firstname or $infomem->lastname)?$infomem->full_name:$infomem->username;
        $data = ['infomem'=>$infomem];
        return FileViewTheme('Members','userpanel',$data);
    }

    public function edit(){
        $infomem = Auth::user();
        $data = [
            'infomem'=>$infomem
        ];
        return FileViewTheme('Members','edit',$data);
    }
    public function postedit(Request $request){
        $infomem = Auth::user();
        if($request->old_password && !Hash::check($request->old_password,$infomem['password']) && $infomem['password'] or is_null($request->old_password) && $request->password && $infomem['password']){
            return redirect()->back()->with('warning', trans('Langcore::members.ErrorOldPassWord'));
        } else {
            $rulepass = ['required', 'string', 'min:6', 'confirmed'];
            $rules = [
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => ['required', 'string', 'email', 'max:255'],
                'avatar'     =>  ['image','mimes:jpeg,png,jpg,gif','max:2048'],
                'password' => ($request->old_password)?$rulepass:''
            ];
            $messages = [
                'firstname.required' => trans('Langcore::members.EmptyFirstname'),
                'lastname.required' => trans('Langcore::members.EmptyLastname'),
                'email.required' => trans('Langcore::members.EmptyEmail')
            ];
            $Validator = Validator::make($request->all(), $rules, $messages);
            if ($Validator -> fails()) {
                return redirect() -> back() -> withErrors($Validator) -> withInput();
            } else {
                $folder = '/uploads/'.$infomem->id;
                $name = ($request->avatar !='')?Str::slug($request->avatar).'_'.time() :'';
                $dbuser = $infomem;
                $dbuser->firstname = $request->firstname;
                $dbuser->lastname = $request->lastname;
                $dbuser->email = $request->email;
                if($request->old_password && Hash::check($request->old_password,$infomem['password']) or !$infomem['password']){
                    if (!$infomem['password'] && !$request->password) {
                        return redirect()->back()->with('warning', trans('Langcore::members.ErrorEmptyPass'));
                    } else {
                        $dbuser->password = Hash::make($request->password);
                    }
                }
                $dbuser->mobile = $request->mobile;
                $dbuser->address = $request->address;
                $dbuser->facebook = $request->facebook;
                $dbuser->skype = $request->skype;
                $dbuser->twitter = $request->twitter;
                $dbuser->youtube = $request->youtube;

                $dbuser->question = $request->question;
                $dbuser->answer = $request->answer;
                $dbuser->about = $request->about;
                $dbuser->gender = $request->gender;

                $http = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')?"https://":"http://";
                // $imgavt = ($request->avatar !='')? Storage::url(ThemesFunc::uploadOne($request->avatar, $folder, 'public', $name)) :''; 
                $imgavt = ($request->avatar !='')? '/storage/'.ThemesFunc::uploadOne($request->avatar, $folder, 'public', $name) :''; 
                $avatar = ($request->avatar !='')?str_replace(url('/'), '', $imgavt):$infomem['avatar'];
                
                $dbuser->avatar = $avatar;
                $dbuser->birthday = $request->birthday;
                $dbuser->website = $request->website;
                $dbuser->save();
                $mess = trans('Langcore::global.SaveSuccess');
                return redirect()->route('members.web.userpanel')->with('success', $mess);
            }
        }
    }


    public function authredirect($provider){
        return Socialite::driver($provider)->redirect();
    }
    public function authcallback($provider){
        $getInfo = Socialite::driver($provider)->user();
        $email = User::where('email',$getInfo->email)->first();
        $user = $this->createUser($getInfo,$provider);
        if (!empty($email)) {
            auth()->login($user);
        }
        if (!$user['password']) {
            return Redirect::route('members.web.edit');
        } else {
            return Redirect::route('members.web.userpanel');
        }
    }
    protected function createUser($getInfo,$provider){
        $user = User::where('provider_id', $getInfo->id)->first();
        if($user) {
            User::where('provider_id', $getInfo->id)->update([
                // 'avatar' => $getInfo->avatar,
                'provider' => $provider,
                'provider_id' => $getInfo->id,
                'online' => '1'
                // 'access_token' => $getInfo->token,
            ]);
        } else {
            $userFirstLastName = $this->getFirstLastNames($getInfo->name);
            $username = array_values(array_filter(explode("@", $getInfo->email)));
            $user = User::create([
                'username' => $username[0].Carbon::now()->toArray()['timestamp'],
                'firstname' => $userFirstLastName['first_name'],
                'lastname' => $userFirstLastName['last_name'],
                'email' => $getInfo->email,
                'email_verified_at' => Date::now(),
                'avatar' => $getInfo->avatar,
                'provider' => $provider,
                'provider_id' => $getInfo->id
            ]);
        }
        return $user;
    }
    protected function getFirstLastNames($fullName)
    {
        $parts = array_values(array_filter(explode(" ", $fullName)));
        $size = count($parts);
        if(empty($parts)){
            $result['first_name']   = NULL;
            $result['last_name']    = NULL;
        }
        if(!empty($parts) && $size == 1){
            $result['first_name']   = $parts[0];
            $result['last_name']    = NULL;
        }
        if(!empty($parts) && $size >= 2){
            $result['first_name']   = $parts[0];
            $result['last_name']    = $parts[1];
        }
        return $result;
    }
    protected function validator(array $data) {
        return Validator::make($data, ['username' => ['required', 'string', 'max:255', 'unique:vsw_users'], 'email' => ['required', 'string', 'email', 'max:255', 'unique:vsw_users'], 'password' => ['required', 'string', 'min:6', 'confirmed'], ]);
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
            'birthday' => $data['birthday'], 
            'mobile' => $data['mobile'],
            'address' => $data['address'],
            'website' => $data['website'],
            'facebook' => $data['facebook'],
            'skype' => $data['skype'],
            'twitter' => $data['twitter'],
            'youtube' => $data['youtube'],
            'question' => $data['question'], 
            'answer' => $data['answer'], 
            'active' => 1, 
        ]);
    }
    protected function registered(Request $request, $user)
    {
        //
    }

}

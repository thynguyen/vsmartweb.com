<?php

namespace Modules\Members\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use Redirect, Auth, View, Storage, Theme, CFglobal, ThemesFunc, ModulesFunc, Carbon, File, Artisan, Exception, AdminFunc, ZipArchive, Response,Avatar;

class AdminMembersController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/admin/members';
    public function main(){
        $data = [];
        return FileViewTheme('Members','main',$data,'admin');
    }
    public function activemem(Request $request) {
        $id = $request->id;
        $dbmember = User::where('id', $id);
        $idmember = $dbmember -> first();
        if ($idmember) {
            $act = ($idmember['active'] == 1) ? 0 : 1;
            $dbmember -> update(['active' => $act]);
            $messenger = ($idmember['active'] == 1) ? trans('Langcore::global.CancelActive') : trans('Langcore::global.SuccessfulActive');
            return Response::json($messenger, 200);
        }
        return Response::json('Error', 404);
    }
    public function deluser(Request $request){
        $id = $request->id;
        $userid = User::where('id',$id)->where('in_group',0)->first();
        if ($userid) {
            $userid->delete();
            return Response::json(trans('Langcore::global.DelSuccess'), 200);
        }
        return Response::json(trans('Langcore::global.CannotBeDeleted'), 404);
    }
    public function edituser($id){
        $data = [
            'infomem'=>User::find($id),
        ];
        return FileViewTheme('Members','edituser',$data,'admin');
    }

    public function postedituser(Request $request,$id){
        $infomem = User::find($id);
        if($request->old_password && !Hash::check($request->old_password,$infomem['password']) or is_null($request->old_password) && $request->password){
            return redirect()->back()->with('warning', transmod('members::ErrorOldPassWord'));
        } else {
            $rulepass = ['required', 'string', 'min:6', 'confirmed'];
            $rules = [
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ($request->old_password)?$rulepass:''
            ];
            $messages = [
                'firstname.required' => transmod('members::EmptyFirstname'),
                'lastname.required' => transmod('members::EmptyLastname'),
                'email.required' => transmod('members::EmptyEmail'),
            ];
            $Validator = Validator::make($request->all(), $rules, $messages);
            if ($Validator -> fails()) {
                return redirect() -> back() -> withErrors($Validator) -> withInput();
            } else {
                $dbuser = $infomem;
                $dbuser->firstname = $request->firstname;
                $dbuser->lastname = $request->lastname;
                $dbuser->email = $request->email;
                if($request->old_password && Hash::check($request->old_password,$infomem['password'])){
                    $dbuser->password = Hash::make($request->password);
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
                $avatar = ($request->avatar !='')? str_replace($http.$_SERVER['HTTP_HOST'], '', $request->avatar) :'';
                
                $dbuser->avatar = $avatar;
                $dbuser->birthday = $request->birthday;
                $dbuser->website = $request->website;
                $dbuser->save();
                $mess = trans('Langcore::global.SaveSuccess');
                return redirect()->route('members.admin.main')->with('success', $mess);
            }
        }
    }

    public function register() {
        return FileViewTheme('Members','register',[],'admin');
    }

    public function postregister(Request $request) {
        $this -> validator($request -> all()) -> validate();

        event(new Registered($user = $this -> create($request -> all())));

        return $this -> registered($request, $user) ? : redirect($this -> redirectPath());
    }
    protected function validator(array $data) {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255', 'unique:vsw_users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:vsw_users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'], 
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data) {
        $http = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')?"https://":"http://";
        $avatar = str_replace($http.$_SERVER['HTTP_HOST'], '', $data['avatar']);
        return User::create([
            'in_group' => 0, 
            'username' => $data['username'], 
            'email' => $data['email'], 
            'password' => Hash::make($data['password']), 
            'firstname' => $data['firstname'], 
            'lastname' => $data['lastname'], 
            'gender' => $data['gender'], 
            'avatar' => $avatar, 
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
}

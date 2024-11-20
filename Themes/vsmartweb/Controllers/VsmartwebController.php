<?php
namespace Themes\vsmartweb\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Date;
use Redirect, Auth, View, Storage, Theme, CFglobal, ThemesFunc, ModulesFunc, File, Artisan, Exception, AdminFunc, ZipArchive, Response, MembersFunc,Avatar,Socialite,LanguageFunc,Form,Mail;
use Carbon\Carbon;
use Vsw\Config\Models\Config;
use Core\Models\Slugs;
use App\User;
/**
 *
 */
class VsmartwebController extends Controller {
    public function indexHome (){
    	$seometa = [
			'title'=>CFglobal::cfn('sitename'),
			'description'=>CFglobal::cfn('site_description'),
			'keyword'=>CFglobal::cfn('site_keywords'),
			'image'=>CFglobal::cfn('site_logo'),
			'canonical'=>1
		];
		ThemesFunc::SEOMeta($seometa);
    	return view('layouts.index');
    }
}
<?php

namespace Core\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Redirect,Auth,View,Validator,Theme,CFglobal,ThemesFunc;

class HomeController extends Controller
{	
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

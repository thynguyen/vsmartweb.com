<?php
namespace Vsw\Comment;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Http\Request;
use File,Exception,Artisan,Validator,Response,Log,Auth,CFglobal;
class CommentFunc
{
	public function GetViewComments($module,$data){
		$data = ['module'=>$module,'data'=>$data];
		return view('layouts.commentsDisplay',$data);
	}
}
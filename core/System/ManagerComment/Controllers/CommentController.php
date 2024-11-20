<?php

namespace Vsw\Comment\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Vsw\Comment\Models\Comment;
use Auth;
   
class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$module)
    {
        // if (Auth::check()) {
            $vldnotauth = (!Auth::check())?'required':'';
        	$request->validate([
                'comment'=>'required',
                'fullname'=>$vldnotauth,
                'email'=>$vldnotauth
            ]);
            $input = $request->all();
            $input['user_id'] = (!Auth::check())?null:auth()->user()->id;
            $input['module'] =  $module;
            $input['locale'] =  app()->getLocale();
            $input['active'] =  0;
            Comment::create($input);
            return redirect()->back()->with('success',trans('Langcore::managercomment.SendCommentSuccess'));
        // } else {
        //     return redirect() -> route('login');
        // }
    }
}

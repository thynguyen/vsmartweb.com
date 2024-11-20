<?php

namespace Vsw\Comment\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Redirect,Auth,View,Storage,Theme,CFglobal,ThemesFunc,Validator,File,Response;
use Vsw\Comment\Models\Comment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminCommentController extends Controller
{
	public function index(){
		return view('System.ManagerComment.main');
	}

	public function active($id) {
		$datacomment = Comment::where('id', $id);
		$idcomment = $datacomment->first();
		if ($idcomment) {
			$act = ($idcomment['active'] == 1) ? 0 : 1;
			$datacomment->update(['active' => $act]);
			$messenger = ($idcomment['active'] == 1) ? trans('Langcore::global.CancelActive') : trans('Langcore::global.SuccessfulActive');
			return Response::json($messenger, 200);
		}
		return Response::json('Error', 404);
	}

	public function edit($id='null'){
		$comment = Comment::find($id);
		$comment->modlower = strtolower($comment->module);
		$comment->title_item = DB::table('vsw_'.$comment->locale.'_'.$comment->modlower)->where('id',$comment->item_id)->pluck('title')->first();
		$data['comment'] = $comment;
		return view('System.ManagerComment.edit',$data);
	}

	public function postedit(Request $request,$id='null'){
		$request->validate([
            'comment'=>'required',
        ]);
        $comment = Comment::find($id);
        $active = ($request->active==1)?1:0;
        $comment->update(['comment'=>$request->comment,'active'=>$active]);
        return redirect()->route('comment.adminindex')->with('success',trans('Langcore::managercomment.SendCommentSuccess'));
	}
	public function delete($id){
		$comment = Comment::find($id);
		if ($comment) {
			if ($comment->delete()) {
				return Response::json(trans('Langcore::global.DelSuccess'), 200);
			}
		}
		return Response::json(trans('Langcore::global.CannotBeDeleted'), 404);
	}
}
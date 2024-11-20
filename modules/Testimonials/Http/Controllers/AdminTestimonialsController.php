<?php

namespace Modules\Testimonials\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Testimonials\Entities\Testimonials;
use Validator,Response;

class AdminTestimonialsController extends Controller
{
    public function main(){
        $data = [];
        return FileViewTheme('Testimonials','main',$data,'admin');
    }
    public function addtestimonial($id='null'){
    	$testimonial = Testimonials::find($id);
    	$data = ['testimonial'=>$testimonial];
    	return FileViewTheme('Testimonials','addtestimonial',$data,'admin');
    }

    public function postaddtestimonial(Request $request,$id='null'){
    	$rules = [];
        $messages = [
        	'required' => trans('validation.required',['attribute'=>''])
        ];
        $Validator = Validator::make($request -> all(), $rules, $messages);
        if ($Validator -> fails()) {
            return redirect() -> back() -> withErrors($Validator) -> withInput();
        } else {
        	$testimonial = ($id=='null')?New Testimonials:Testimonials::find($id);
        	$testimonial->fullname = $request->fullname;
        	$testimonial->mobile = $request->mobile;
        	$testimonial->email = $request->email;
        	$testimonial->address = $request->address;
        	$testimonial->avatar = str_replace(url('/'), '', $request->avatar);
        	$testimonial->testimonial = $request->testimonial;
        	$testimonial->active = 1;
        	$testimonial->save();

        	if ($testimonial) {
        		return redirect()->back() -> with('success', trans('Langcore::global.SaveSuccess'));
        	}
        }
    }
    public function activetestimonial(Request $request) {
        $id = $request->id;
        $dbtestimonial = Testimonials::where('id', $id);
        $idtestimonial = $dbtestimonial -> first();
        if ($idtestimonial) {
            $act = ($idtestimonial['active'] == 1) ? 0 : 1;
            $dbtestimonial -> update(['active' => $act]);
            $messenger = ($idtestimonial['active'] == 1) ? trans('Langcore::global.CancelActive') : trans('Langcore::global.SuccessfulActive');
            return Response::json($messenger, 200);
        }
        return Response::json('Error', 404);
    }
	public function deltestimonial(Request $request){
		$id = $request->id;
		$testimonial = Testimonials::where('id',$id)->first();
		if ($testimonial) {
			if ($testimonial->delete()) {
				return Response::json(trans('Langcore::global.DelSuccess'), 200);
			}
		}
		return Response::json(trans('Langcore::global.CannotBeDeleted'), 404);
	}
}

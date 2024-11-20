<?php

namespace Modules\Sliders\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Redirect,Auth,View,Storage,Theme,CFglobal,ThemesFunc,Validator,Carbon,AdminFunc,Response,Image,File;
use Modules\Sliders\Entities\Sliders;
use Modules\Sliders\Entities\SldGroup;
use Modules\Sliders\Entities\SldTemp;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AdminSlidersController extends Controller {
	public function main(){
		$groupid = (SldGroup::first())?SldGroup::first()->id:0;
		$groups = SldGroup::get();
		$data = ['groups'=>$groups,'groupid'=>$groupid];
		return view('sliders::admin.main',$data);
	}
	public function addgroup($id='null'){
		$group = SldGroup::find($id);
		$data = ['group'=>$group];
		return view('sliders::admin.addgroup',$data);
	}
	public function postaddgroup(Request $request,$id='null'){
		$rules = [];
        $messages = [
        	'required' => trans('validation.required',['attribute'=>''])
        ];
        $Validator = Validator::make($request -> all(), $rules, $messages);
        if ($Validator -> fails()) {
            return redirect() -> back() -> withErrors($Validator) -> withInput();
        } else {
        	$group = ($id=='null')?New SldGroup:SldGroup::find($id);
        	$group->title = $request->title;
        	$group->description = $request->description;
        	$group->save();
        	if ($group) {
        		return redirect()->back() -> with('success', trans('Langcore::global.SaveSuccess'));
        	}
        }
	}
	public function delgroup(Request $request){
		$group = SldGroup::with(['slider'])->where('id',$request->id)->first();
		if (count($group->slider)==0) {
			if ($group->delete()) {
				return Response::json(trans('Langcore::global.DelSuccess'), 200);
			}
			return Response::json(trans('Langcore::global.CannotBeDeleted'), 404);
		} else {
			return Response::json(trans('Langcore::global.CannotBeDeleted'), 404);
		}
	}

	public function listsliders($groupid){
		$group = SldGroup::with(['slider'=>function($query){
			$query->orderBy('weight');
		}])->where('id',$groupid)->first();
		foreach ($group->slider as $slider) {
			$slider->thumb = ThemesFunc::GetThumb($slider->image,80);
		}
		$numdoc = count($group->slider);
		$table = 'vsw_'.app()->getLocale().'_sliders';
		$data = ['group'=>$group,'numdoc'=>$numdoc,'table'=>$table];
		return view('sliders::admin.listsliders',$data);
	}
	public function addslider($groupid,$id='null'){
		if (!File::exists(storage_path('app/public/uploads/sliders'))) {
			File::makeDirectory(storage_path('app/public/uploads/sliders'), 0755, true);
		}

		$basecover = base_path('Themes').DIRECTORY_SEPARATOR.CFglobal::cfn('theme').DIRECTORY_SEPARATOR.'views/widgets/Sliders/templates/';
        $filecover = glob($basecover.'*.blade.php');
        $filecover = array_reverse($filecover);
        $filecover = array_filter($filecover, 'is_file');
        $templates = [];
        $templates['default'] = 'Default';
        foreach ($filecover as $files => $file) {
            $file_name = basename($file);
            if(file_exists($basecover.$file_name)) {
                $temp = str_replace(['.blade.php'], '', $file_name);
                $templates[$temp] = $temp;
            }
        }
        asort($templates);
		$slider = Sliders::with(['template'])->where('id',$id)->first();
		$data = [
			'id'=>$id,
			'groupid'=>$groupid,
			'slider'=>$slider,
			'templates'=>$templates
		];
		return view('sliders::admin.addslider',$data);
	}
	public function submitaddslider(Request $request){
		$rules = [];
        $messages = [
        	'required' => trans('validation.required',['attribute'=>''])
        ];
        $Validator = Validator::make($request -> all(), $rules, $messages);
        if ($Validator -> fails()) {
            return redirect() -> back() -> withErrors($Validator) -> withInput();
        } else {
        	$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')?"https://":"http://";
        	$slider = ($request->id==null)?New Sliders:Sliders::find($request->id);
        	$slider->groupid = $request->groupid;
        	$slider->title = $request->title;
        	$slider->description = $request->description;
        	$slider->image = str_replace($link.$_SERVER['HTTP_HOST'], '', $request->image);
        	$slider->link = $request->link;
        	$slider->custom_id = $request->custom_id;
        	$slider->custom_class = $request->custom_class;

        	if ($request->id==null) {
	        	$weight = Sliders::where('groupid', $request->groupid)->max('weight');
	        	$maxWeight = intval($weight) + 1; 
	        	$slider->weight = $maxWeight;
        	}

        	$slider->save();
			if ($slider) {
				if ($request->template != 'default') {
		        	$sldtemp = SldTemp::where('sliderid',$slider->id)->where('theme',CFglobal::cfn('theme'))->first();
		        	$template = ($sldtemp)?$sldtemp:New SldTemp;
		        	$template->sliderid = $slider->id;
		        	$template->template = $request->template;
		        	$template->theme = CFglobal::cfn('theme');
		        	$template->save();
				}

        	
        		$msg = trans('Langcore::global.SaveSuccess');
        		$data = ['msg'=>$msg,'data'=>$slider];
        		return $data;
        	}
        }
	}
	public function changesliderweight(Request $request){
		$idrow = Sliders::where('id',$request->id)->first();
		if ($idrow) {
			$rows = Sliders::where('id','!=',$request->id)->where('groupid',$request->groupid)->orderBy('weight', 'asc')->pluck('id');
			$weight = 0;
			foreach ($rows as $rowid) {
				$weight++;
				if ($weight == $request->newweight) {
					$weight++;
				}
				Sliders::where('id',$rowid)->update(['weight'=>$weight]);
			}
			Sliders::where('id',$request->id)->update(['weight'=>$request->newweight]);
			return Response::json(trans('Langcore::language.SuccessChangeWeight'), 200);
		}
		return Response::json(trans('Langcore::language.ErrorChangeWeight'), 400);
	}

	public function delslider(Request $request){
		$id = $request->id;
		$slider = Sliders::where('id',$id)->first();
		if ($slider->delete()) {
			$sliders = Sliders::where('groupid', $request->groupid)->orderBy('id', 'asc')->get();
			$weight = 0;
			foreach ($sliders as $key => $value) {
				++$weight;
				$update_weight = Sliders::find($value['id']);
				$update_weight->weight = $weight;
				$update_weight->save();
			}
			SldTemp::where('sliderid',$id)->delete();
			return Response::json(trans('Langcore::global.DelSuccess'), 200);
		} else {
			return Response::json(trans('Langcore::global.CannotBeDeleted'), 404);
		}
	}
}
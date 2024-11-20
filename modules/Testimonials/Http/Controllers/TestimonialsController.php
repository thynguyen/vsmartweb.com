<?php

namespace Modules\Testimonials\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Testimonials\Entities\Testimonials;
use Illuminate\Support\Str;
use Validator,File,Storage,ThemesFunc;

class TestimonialsController extends Controller
{
    public function main(){
        $data = [];
        return FileViewTheme('Testimonials','main',$data);
    }
    public function addtestimonial(Request $request){
        $vldcapcha = (env('RECAPTCHA_SECRET_KEY') && env('RECAPTCHA_SITE_KEY'))?'required|recaptcha':'';
        $rules = [
            'fullname' => 'string|required',
            'email' => ['required', 'string', 'email', 'max:255'],
            'testimonial' => 'string|required',
            'g-recaptcha-response' => $vldcapcha
        ];
        $messages = [
            'required' => trans('validation.required',['attribute'=>'']),
            'g-recaptcha-response.required'=>trans('Langcore::global.NotConfirmedCaptcha'),
            'g-recaptcha-response.captcha'=>trans('Langcore::global.IncorrectCaptcha')
        ];
        $Validator = Validator::make($request->all(), $rules, $messages);
        if ($Validator -> fails()) {
            return redirect() -> back() -> withErrors($Validator) -> withInput();
        } else {
            if (!File::exists(storage_path('app/public/uploads/testimonial'))) {
                File::makeDirectory(storage_path('app/public/uploads/testimonial'), 0777, true);
            }
            $folder = '/uploads/testimonial';
            $name = Str::slug($request->avatar).'_'.time();
            $imgavt = Storage::url(ThemesFunc::uploadOne($request->avatar, $folder, 'public', $name)); 
            $avatar = str_replace([url('/'),str_replace(['http:','https:'],'',url('/'))], '', $imgavt);

            $testimonial = New Testimonials;
            $testimonial->fullname = $request->fullname;
            $testimonial->mobile = $request->mobile;
            $testimonial->email = $request->email;
            $testimonial->address = $request->address;
            $testimonial->avatar = $avatar;
            $testimonial->testimonial = $request->testimonial;
            $testimonial->active = 0;
            $testimonial->save();

            $mess = trans('Langcore::global.SaveSuccess');
            return redirect()->back()->with('success', $mess);
        }
    }
}

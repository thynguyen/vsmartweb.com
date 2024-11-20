<?php

namespace CoreMW;

use Illuminate\Http\Request;
use Closure,Auth,AdminFunc,File;

class CheckAdmin
{
	/**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$module)
    {
        if ($this->CheckInstalled()) {
            $user = Auth::user();
            if ($user->in_group<=2) {
                if ($user->in_group==1 or $user->in_group==2 && AdminFunc::AdminPerMSMW($module)==1) {
                    return $next($request);
                } else {
                    return redirect()->back();
                }
            } else {
                return redirect()->back();
            }
        } else {
            return redirect('install');
        }
    }

    public function CheckInstalled()
    {
        return file_exists(storage_path('installed'));
    }
}